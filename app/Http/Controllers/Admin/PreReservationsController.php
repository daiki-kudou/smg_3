<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\PreReservation;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use App\Models\MultipleReserve;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminFinPreRes;
use App\Mail\UserFinPreRes;
// キャンセル
use App\Mail\AdminPreResCxl;
use App\Mail\UserPreResCxl;

use App\Traits\SearchTrait;

use App\Traits\PaginatorTrait;

class PreReservationsController extends Controller
{
  use SearchTrait; //検索用トレイト
  use PaginatorTrait;


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $today = date('Y-m-d', strtotime(Carbon::today()));

    if (!empty($request->time_over)) {
      $today = Carbon::now();
      $threeDaysBefore = date('Y-m-d H:i:s', strtotime($today->subHours(72)));
      $result = PreReservation::where('status', 1)->where('updated_at', '<', $threeDaysBefore);
      $pre_reservations = $result->orderBy('id', 'desc')->paginate(30);
      $counter = $result->count();
    } elseif (count($request->all()) != 0) {
      $class = new PreReservation;
      $result = $this->BasicSearch($class->with(["unknown_user", "pre_enduser"]), $request);
      $pre_reservations = $result[0];
      $counter = $result[1];
    } else {
      // $pre_reservations = PreReservation::with(["unknown_user", "pre_enduser"])->where('multiple_reserve_id', '=', 0)->orderBy('id', 'desc')->paginate(30);
      // $counter = 0;
      $after = PreReservation::with(["unknown_user", "pre_enduser"])->where('multiple_reserve_id', '=', 0)->where('reserve_date', '>=', $today)->get()->sortBy('reserve_date');
      $before = PreReservation::with(["unknown_user", "pre_enduser"])->where('multiple_reserve_id', '=', 0)->where('reserve_date', '<', $today)->get()->sortByDesc('reserve_date');
      $pre_reservations = $after->concat($before);
      $pre_reservations = $this->customPaginate($pre_reservations, 30, $request);
      $counter = 0;
    }

    $venues = Venue::all();
    $agents = Agent::all();
    return view(
      'admin.pre_reservations.index',
      compact('pre_reservations', 'venues', 'agents', "counter", 'request')
    );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::all();
    $venues = Venue::all();
    return view('admin.pre_reservations.create', [
      'users' => $users,
      'venues' => $venues,
    ]);
  }

  public function check(Request $request)
  {
    $judge_count = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/pre_date/', $key)) {
        $judge_count[] = $value;
      }
    }
    if (count($judge_count) == 1) {
      $venue = Venue::with(['equipments', 'services', 'frame_prices', 'time_prices'])->find($request->pre_venue0);
      $layouts = [];
      $layouts[] = $venue->layout_prepare == 0 ? 0 : $venue->layout_prepare;
      $layouts[] = $venue->layout_clean == 0 ? 0 : $venue->layout_clean;
      return view('admin.pre_reservations.single_check', compact('request', 'venue', 'layouts'));
    } else {
      $multiple = MultipleReserve::create(); //一括IDを作成
      $multiple->MultipleStore($request);
      $request->session()->regenerate();
      return redirect('admin/multiples');
    }
  }

  public function calculate(Request $request)
  {
    if ($request->judge_count == 1) { //単発仮押えの計算

      $SpVenue = Venue::with(['equipments', 'services', 'frame_prices', 'time_prices'])->find($request->venue_id);
      $price_details = $SpVenue->calculate_price( //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
        $request->price_system,
        $request->enter_time,
        $request->leave_time
      );

      $s_equipment = [];
      $s_services = [];
      foreach ($request->all() as $key => $value) {
        if (preg_match('/equipment_breakdown/', $key)) {
          $s_equipment[] = $value;
        }
        if (preg_match('/services_breakdown/', $key)) {
          $s_services[] = $value;
        }
      }
      $item_details = $SpVenue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
      $layouts_details = $SpVenue->getLayoutPrice($request->layout_prepare, $request->layout_clean);

      if ($price_details == 0) { //枠がなく会場料金を手打ちするパターン
        $masters =
          ($item_details[0] + $request->luggage_price)
          + $layouts_details[2];
      } else {
        $masters =
          ($price_details[0] ? $price_details[0] : 0)
          + ($item_details[0] + $request->luggage_price)
          + $layouts_details[2];
      }
      $user = User::find($request->user_id);
      $pay_limit = $user->getUserPayLimit($request->reserve_date);

      return view('admin.pre_reservations.single_calculate', compact(
        'SpVenue',
        'request',
        'price_details',
        'item_details',
        'layouts_details',
        'masters',
      ));
    }
  }

  public function re_calculate(Request $request)
  {
    if ($request->judge_count == 1) { //単発仮押えの計算
      $users = User::all();
      $SPVenue = Venue::with(['equipments', 'services', 'frame_prices'])->find($request->venue_id);
      $price_details = $SPVenue->calculate_price( //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
        $request->price_system,
        $request->enter_time,
        $request->leave_time
      );

      $s_equipment = [];
      $s_services = [];
      foreach ($request->all() as $key => $value) {
        if (preg_match('/equipment_breakdown/', $key)) {
          $s_equipment[] = $value;
        }
        if (preg_match('/services_breakdown/', $key)) {
          $s_services[] = $value;
        }
      }
      $item_details = $SPVenue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
      $layouts_details = $SPVenue->getLayoutPrice($request->layout_prepare, $request->layout_clean);

      if ($price_details == 0) { //枠がなく会場料金を手打ちするパターン
        $masters =
          ($item_details[0] + $request->luggage_price)
          + $layouts_details[2];
      } else {
        $masters =
          ($price_details[0] ? $price_details[0] : 0)
          + ($item_details[0] + $request->luggage_price)
          + $layouts_details[2];
      }
      $user = User::find($request->user_id);
      $pay_limit = $user->getUserPayLimit($request->reserve_date);

      return view(
        'admin.pre_reservations.single_re_calculate',
        compact(
          'users',
          'request',
          'price_details',
          'item_details',
          'layouts_details',
          'masters',
          'SPVenue'
        )
      );
    }
  }


  public function getuser(Request $request)
  {
    return User::find($request->user_id);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if ($request->judge_count == 1) { //単発仮押えの保存
      // $request->validate([
      //   'venue_id' => 'required',
      //   'start' => 'required',
      //   'user_id' => 'required',
      //   'agent_id' => 'required',
      //   'reserve_date' => 'required',
      //   'price_system' => 'required',
      // ]);

      $new_preReserve = DB::transaction(function () use ($request) { //トランザクションさせる
        $pre_reservation = PreReservation::create([
          'multiple_reserve_id' => 0, //単発はデフォで0
          'venue_id' => $request->venue_id,
          'user_id' => $request->user_id,
          'agent_id' => 0, //デフォで0
          'reserve_date' => $request->reserve_date,
          'price_system' => $request->price_system,
          'enter_time' => $request->enter_time,
          'leave_time' => $request->leave_time,
          'board_flag' => $request->board_flag,
          'event_start' => $request->event_start,
          'event_finish' => $request->event_finish,
          'event_name1' => $request->event_name1,
          'event_name2' => $request->event_name2,
          'event_owner' => $request->event_owner,
          'luggage_count' => $request->luggage_count,
          'luggage_arrive' => $request->luggage_arrive,
          'luggage_return' => $request->luggage_return,
          'email_flag' => $request->email_flag,
          'in_charge' => $request->in_charge,
          'tel' => $request->tel,
          'discount_condition' => $request->discount_condition,
          'attention' => $request->attention,
          'user_details' => $request->user_details,
          'admin_details' => $request->admin_details,
          'status' => 0, //デフォで0この時点でユーザーにはメールは送付されない
          'eat_in' => $request->eat_in,
          'eat_in_prepare' => $request->eat_in_prepare,
          'cost' => !empty($request->cost) ? $request->cost : 0,
        ]);

        $pre_bills = $pre_reservation->pre_bill()->create([
          'pre_reservation_id' => $pre_reservation->id,
          'venue_price' => $request->venue_price,
          'equipment_price' => $request->equipment_price ? $request->equipment_price : 0, //備品・サービス・荷物
          'layout_price' => $request->layout_price ? $request->layout_price : 0,
          'others_price' => $request->others_price ? $request->others_price : 0,
          // 該当billの合計額関連
          'master_subtotal' => $request->master_subtotal,
          'master_tax' => $request->master_tax,
          'master_total' => $request->master_total,

          'reservation_status' => 0, //デフォで1、仮押えのデフォは0
          'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
          'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
        ]);
        function toBreakDown($num, $sub, $target, $type, $instance)
        {
          $s_arrays = [];
          foreach ($num as $key => $value) {
            if (preg_match("/" . $sub . "/", $key)) {
              $s_arrays[] = $value;
            }
          }
          $counts = (count($s_arrays) / 4);
          for ($i = 0; $i < $counts; $i++) {
            $target->pre_breakdowns()->create([
              'pre_bill_id' => $instance,
              'unit_item' => $s_arrays[($i * 4)],
              'unit_cost' => $s_arrays[($i * 4) + 1],
              'unit_count' => $s_arrays[($i * 4) + 2],
              'unit_subtotal' => $s_arrays[($i * 4) + 3],
              'unit_type' => $type,
            ]);
          }
        }
        toBreakDown($request->all(), 'venue_breakdown', $pre_bills, 1, $pre_bills->id);
        toBreakDown($request->all(), 'equipment_breakdown', $pre_bills, 2, $pre_bills->id);
        toBreakDown($request->all(), 'services_breakdown', $pre_bills, 3, $pre_bills->id);

        if ($request->others_price) {
          toBreakDown($request->all(), 'others_input', $pre_bills, 5, $pre_bills->id);
        }

        if ($request->luggage_subtotal) {
          $pre_bills->pre_breakdowns()->create([
            'pre_bill_id' => $pre_bills->id,
            'unit_item' => $request->luggage_item,
            'unit_cost' => $request->luggage_cost,
            'unit_count' => 1,
            'unit_subtotal' => $request->luggage_subtotal,
            'unit_type' => 3,
          ]);
        }
        if ($request->layout_prepare_subtotal) {
          $pre_bills->pre_breakdowns()->create([
            'pre_bill_id' => $pre_bills->id,
            'unit_item' => $request->layout_prepare_item,
            'unit_cost' => $request->layout_prepare_cost,
            'unit_count' => $request->layout_prepare_count,
            'unit_subtotal' => $request->layout_prepare_subtotal,
            'unit_type' => 4,
          ]);
        }
        if ($request->layout_clean_subtotal) {
          $pre_bills->pre_breakdowns()->create([
            'pre_bill_id' => $pre_bills->id,
            'unit_item' => $request->layout_clean_item,
            'unit_cost' => $request->layout_clean_cost,
            'unit_count' => $request->layout_clean_count,
            'unit_subtotal' => $request->layout_clean_subtotal,
            'unit_type' => 4,
          ]);
        }
        if ($request->layout_breakdown_discount_item) {
          $pre_bills->pre_breakdowns()->create([
            'pre_bill_id' => $pre_bills->id,
            'unit_item' => $request->layout_breakdown_discount_item,
            'unit_cost' => $request->layout_breakdown_discount_cost,
            'unit_count' => $request->layout_breakdown_discount_count,
            'unit_subtotal' => $request->layout_breakdown_discount_subtotal,
            'unit_type' => 4,
          ]);
        }

        if (
          $request->unknown_user_company ||
          $request->unknown_user_name ||
          $request->unknown_user_email ||
          $request->unknown_user_tel ||
          $request->unknown_user_mobile
        ) {
          $pre_reservation->unknown_user()->create([
            'pre_reservation_id' => $pre_reservation->id,
            'unknown_user_company' => $request->unknown_user_company,
            'unknown_user_name' => $request->unknown_user_name,
            'unknown_user_email' => $request->unknown_user_email,
            'unknown_user_tel' => $request->unknown_user_tel,
            'unknown_user_mobile' => $request->unknown_user_mobile
          ]);
        }
        return $pre_reservation;
      });

      // 戻って再度送信してもエラーになるように設定
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.show', $new_preReserve->id)->with('flash_message', '単発仮押えの登録が完了しました');
    } else {
      //複数仮押えの保存
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $pre_reservation = PreReservation::with("pre_bill.pre_breakdowns")->find($id);
    $SPVenue = Venue::find($pre_reservation->venue_id);
    return view(
      'admin.pre_reservations.show',
      compact(
        'pre_reservation',
        'SPVenue'
      )
    );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $PreReservation = PreReservation::with("pre_bill")->find($id);
    $users = User::all();
    $venues = Venue::with(["frame_prices", "time_prices"])->get();
    $SPVenue = $venues->find($PreReservation->venue_id);

    return view(
      'admin.pre_reservations.edit',
      compact('PreReservation', 'users', 'venues', 'SPVenue')
    );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request = $request->merge(['status' => 0]); //現段階ではステータスを0に。
    $pre_reservation = PreReservation::find($id);
    $pre_reservation->Updates($request);
    $pre_bill = new PreBill;
    $pre_bill->PreBillCreate($request, $pre_reservation);
    $pre_breakdowns = new PreBreakdown;
    $pre_breakdowns->PreBreakdownCreate($request, $pre_reservation);
    $request->session()->regenerate();
    return redirect()->route('admin.pre_reservations.index');
  }

  public function get_user(Request $request)
  {
    $user = User::find($request->user_id);
    return [
      $user->company,
      $user->first_name,
      $user->last_name,
      $user->email,
      $user->mobile,
      $user->tel,
      $user->id,
      $user->condition,
      $user->attention,
    ];
  }

  public function edit_update(Request $request, $id)
  {
    DB::transaction(function () use ($request, $id) { //トランザクションさせる
      $pre_reservation = PreReservation::find($id);
      $pre_reservation->update([
        'user_id' => $request->user_id,
        'price_system' => $request->price_system,
        'enter_time' => $request->enter_time,
        'leave_time' => $request->leave_time,
        'board_flag' => $request->board_flag,
        'event_start' => $request->event_start,
        'event_finish' => $request->event_finish,
        'event_name1' => $request->event_name1,
        'event_name2' => $request->event_name2,
        'event_owner' => $request->event_owner,
        'luggage_count' => $request->luggage_count,
        'luggage_arrive' => $request->luggage_arrive,
        'luggage_return' => $request->luggage_return,
        'email_flag' => $request->email_flag,
        'in_charge' => $request->in_charge,
        'tel' => $request->tel,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        'cost' => $request->cost,
      ]);

      // 内訳削除
      foreach ($pre_reservation->pre_breakdowns()->get() as $bre) {
        $bre->delete();
      }
      // 請求書削除
      $bill_del = $pre_reservation->pre_bill()->first()->delete();
      // 未登録ユーザー削除
      if (!empty($pre_reservation->unknown_user)) {
        $pre_reservation->unknown_user->delete();
      }


      // 再作成
      $pre_bills = $pre_reservation->pre_bill()->create([
        'pre_reservation_id' => $pre_reservation->id,
        'venue_price' => $request->venue_price,
        'equipment_price' => $request->equipment_price ? $request->equipment_price : 0, //備品・サービス・荷物
        'layout_price' => $request->layout_price ? $request->layout_price : 0,
        'others_price' => $request->others_price ? $request->others_price : 0,
        // 該当billの合計額関連
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,

        'reservation_status' => 0, //デフォで1、仮押えのデフォは0
        'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
      ]);
      function toBreakDowns($num, $sub, $target, $type)
      {
        $s_arrays = [];
        foreach ($num as $key => $value) {
          if (preg_match("/" . $sub . "/", $key)) {
            $s_arrays[] = $value;
          }
        }
        $counts = (count($s_arrays) / 4);
        for ($i = 0; $i < $counts; $i++) {
          $target->pre_breakdowns()->create([
            'unit_item' => $s_arrays[($i * 4)],
            'unit_cost' => $s_arrays[($i * 4) + 1],
            'unit_count' => $s_arrays[($i * 4) + 2],
            'unit_subtotal' => $s_arrays[($i * 4) + 3],
            'unit_type' => $type,
          ]);
        }
      }
      toBreakDowns($request->all(), 'venue_breakdown', $pre_bills, 1);
      toBreakDowns($request->all(), 'equipment_breakdown', $pre_bills, 2);
      toBreakDowns($request->all(), 'services_breakdown', $pre_bills, 3);

      if ($request->others_price) {
        toBreakDowns($request->all(), 'others_input', $pre_bills, 5);
      }

      if ($request->luggage_subtotal) {
        $pre_bills->pre_breakdowns()->create([
          'unit_item' => $request->luggage_item,
          'unit_cost' => $request->luggage_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->luggage_subtotal,
          'unit_type' => 3,
        ]);
      }
      if ($request->layout_prepare_subtotal) {
        $pre_bills->pre_breakdowns()->create([
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => $request->layout_prepare_count,
          'unit_subtotal' => $request->layout_prepare_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_subtotal) {
        $pre_bills->pre_breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => $request->layout_clean_count,
          'unit_subtotal' => $request->layout_clean_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_breakdown_discount_item) {
        $pre_bills->pre_breakdowns()->create([
          'unit_item' => $request->layout_breakdown_discount_item,
          'unit_cost' => $request->layout_breakdown_discount_cost,
          'unit_count' => $request->layout_breakdown_discount_count,
          'unit_subtotal' => $request->layout_breakdown_discount_subtotal,
          'unit_type' => 4,
        ]);
      }

      if (
        $request->unknown_user_company ||
        $request->unknown_user_name ||
        $request->unknown_user_email ||
        $request->unknown_user_tel ||
        $request->unknown_user_mobile
      ) {
        $pre_reservation->unknown_user()->create([
          'unknown_user_company' => $request->unknown_user_company,
          'unknown_user_name' => $request->unknown_user_name,
          'unknown_user_email' => $request->unknown_user_email,
          'unknown_user_tel' => $request->unknown_user_tel,
          'unknown_user_mobile' => $request->unknown_user_mobile
        ]);
      }
    });
    $request->session()->regenerate();
    return redirect()->route('admin.pre_reservations.show', $id);
  }

  public function switchStatus(Request $request)
  {
    $PreReservation = PreReservation::find($request->pre_reservation_id);
    DB::transaction(function () use ($request, $PreReservation) {
      $PreReservation->update(['status' => 1]);
    });
    $admin = explode(',', config('app.admin_email'));


    Mail::to($admin) //管理者
      ->send(new AdminFinPreRes(
        $PreReservation->user->company,
        $PreReservation->id,
        $PreReservation->reserve_date,
        $PreReservation->enter_time,
        $PreReservation->leave_time,
        $PreReservation->venue->name_area . $PreReservation->venue->name_bldg . $PreReservation->venue->name_venue,
        $PreReservation->venue->post_code,
        $PreReservation->venue->address1 . $PreReservation->venue->address2 . $PreReservation->venue->address3,
        url('/') . '/user/pre_reservations'
      ));
    Mail::to($PreReservation->user->email) //ユーザー
      ->send(new UserFinPreRes(
        $PreReservation->user->company,
        $PreReservation->id,
        $PreReservation->reserve_date,
        $PreReservation->enter_time,
        $PreReservation->leave_time,
        $PreReservation->venue->name_area . $PreReservation->venue->name_bldg . $PreReservation->venue->name_venue,
        $PreReservation->venue->post_code,
        $PreReservation->venue->address1 . $PreReservation->venue->address2 . $PreReservation->venue->address3,
        url('/') . '/user/pre_reservations'
      ));


    $request->session()->regenerate();
    return redirect()->route('admin.pre_reservations.show', $request->pre_reservation_id);
  }

  public function rejectSameTime(Request $request)
  {
    $first = new Carbon($request->targetEnter);
    $second = new Carbon($request->targetLeave);
    $diff = ($first->diffInMinutes($second)) / 30;
    $target = "";
    $arrays = [];
    for ($i = 0; $i < $diff; $i++) {
      $target =
        $arrays[] = $target;
    }

    return [$diff, $request->targetEnter, $request->targetLeave];
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    if (count($request->all()) == 1) {
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.index')->with('flash_message_error', '仮押えが選択されていません');
    } else {
      DB::transaction(function () use ($request) { //トランザクションさせる
        foreach ($request->all() as $key => $value) {
          $pre_reservation = PreReservation::find((int) $value);
          if ($pre_reservation) {
            $pre_reservation->delete();
            $admin = explode(',', config('app.admin_email'));
            $user = User::find($pre_reservation->user_id);

            try {
              $user->email;
            } catch (\Exception $e) {
              DB::rollBack();
              echo 'failed';
              return redirect()->route('admin.pre_reservations.index')->with('flash_message_error', '一部ユーザーのメールアドレスに誤りがあり送信できませんでした');
            }

            Mail::to($admin) //管理者
              ->send(new AdminPreResCxl($pre_reservation, $user));
            Mail::to($user->email) //ユーザ
              ->send(new UserPreResCxl($pre_reservation, $user));
          }
        }
      });
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.index');
    }
  }
}
