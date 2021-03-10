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

use App\Traits\SearchTrait;


class PreReservationsController extends Controller
{
  use SearchTrait; //検索用トレイト

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    // $test = $this->SplitDate($request->search_date);
    // var_dump($test);

    // var_dump($this->BasicSearch(new PreReservation, $request));
    $pre_reservations = $this->BasicSearch(new PreReservation, $request);

    // if (count($request->all()) != 0) {
    //   $class = new PreReservation;
    //   $pre_reservations = $this->BasicSearch($class, $request);
    // } else {
    //   $pre_reservations = PreReservation::where('multiple_reserve_id', '=', 0)->paginate(30);
    // }





    // $pre_reservations = PreReservation::where('multiple_reserve_id', '=', 0)->paginate(30);
    $venues = Venue::all();
    $users = User::all();
    $agents = Agent::all();
    return view(
      'admin.pre_reservations.index',
      compact('pre_reservations', 'venues', 'users', 'agents')
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
      $venue = Venue::find($request->pre_venue0);
      $equipments = $venue->equipments()->get();
      $services = $venue->services()->get();
      $layouts = [];
      $layouts[] = $venue->layout_prepare == 0 ? 0 : $venue->layout_prepare;
      $layouts[] = $venue->layout_clean == 0 ? 0 : $venue->layout_clean;

      return view('admin.pre_reservations.single_check', [
        'request' => $request,
        'equipments' => $equipments,
        'services' => $services,
        'venue' => $venue,
        'layouts' => $layouts,
      ]);
    } else {
      DB::transaction(function () use ($request) { //トランザクションさせる
        $multiple = MultipleReserve::create(); //一括IDを作成
        $counters = [];
        foreach ($request->all() as $key => $value) {
          if (preg_match('/pre_date/', $key)) {
            $counters[] = $value;
          }
        }
        $counters = count($counters);
        for ($i = 0; $i < $counters; $i++) {
          $pre_reservations = $multiple->pre_reservations()->create([
            'venue_id' => $request->{'pre_venue' . $i},
            'user_id' => $request->user_id,
            'agent_id' => 0,
            'reserve_date' => $request->{'pre_date' . $i},
            'enter_time' => $request->{'pre_enter' . $i},
            'leave_time' => $request->{'pre_leave' . $i},
            'status' => 0
          ]);
          if ($request->unknown_user_company) {
            $pre_reservations->unknown_user()->create([
              'unknown_user_company' => $request->unknown_user_company,
              'unknown_user_name' => $request->unknown_user_name,
              'unknown_user_email' => $request->unknown_user_email,
              'unknown_user_mobile' => $request->unknown_user_mobile,
              'unknown_user_tel' => $request->unknown_user_tel,
            ]);
          }
        }
      });

      $request->session()->regenerate();
      return redirect('admin/multiples');
    }
  }

  public function calculate(Request $request)
  {
    if ($request->judge_count == 1) { //単発仮押さえの計算
      var_dump($request->all());
      $users = User::all();
      $venues = Venue::all();
      $SpVenue = $venues->find($request->venue_id);
      $equipments = $SpVenue->equipments()->get();
      $services = $SpVenue->services()->get();

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

      return view('admin.pre_reservations.single_calculate', [
        'venues' => $venues,
        'SpVenue' => $SpVenue,
        'users' => $users,
        'request' => $request,
        'equipments' => $equipments,
        'services' => $services,
        's_equipment' => $s_equipment, //選択された備品
        's_services' => $s_services, //選択されたサービス
        'price_details' => $price_details,
        'item_details' => $item_details,
        'layouts_details' => $layouts_details,
        'masters' => $masters,
        'pay_limit' => $pay_limit,
        'user' => $user,

      ]);
    }
  }

  public function re_calculate(Request $request)
  {
    if ($request->judge_count == 1) { //単発仮押さえの計算
      // 
      $users = User::all();
      $venues = Venue::all();
      $venue = $venues->find($request->venue_id);
      $equipments = $venue->equipments()->get();
      $services = $venue->services()->get();

      $price_details = $venue->calculate_price( //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
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
      $item_details = $venue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
      $layouts_details = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean);

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

      return view('admin.pre_reservations.single_re_calculate', [
        'venues' => $venues,
        'users' => $users,
        'request' => $request,
        'equipments' => $equipments,
        'services' => $services,
        's_equipment' => $s_equipment, //選択された備品
        's_services' => $s_services, //選択されたサービス
        'price_details' => $price_details,
        'item_details' => $item_details,
        'layouts_details' => $layouts_details,
        'masters' => $masters,
        'pay_limit' => $pay_limit,
        'user' => $user,

      ]);
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
    if ($request->judge_count == 1) { //単発仮押さえの保存
      DB::transaction(function () use ($request) { //トランザクションさせる
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
          'cost' => $request->cost,
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

          'reservation_status' => 0, //デフォで1、仮押さえのデフォは0
          'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
          'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
        ]);
        function toBreakDown($num, $sub, $target, $type)
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
        toBreakDown($request->all(), 'venue_breakdown', $pre_bills, 1);
        toBreakDown($request->all(), 'equipment_breakdown', $pre_bills, 2);
        toBreakDown($request->all(), 'services_breakdown', $pre_bills, 3);

        if ($request->others_price) {
          toBreakDown($request->all(), 'others_input', $pre_bills, 5);
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

      // 戻って再度送信してもエラーになるように設定
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.index')->with('flash_message', '単発仮押さえの登録が完了しました');
    } else {
      //複数仮押さえの保存
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
    $pre_reservation = PreReservation::find($id);
    $venues = $pre_reservation->pre_breakdowns->where('unit_type', 1);
    $equipments = $pre_reservation->pre_breakdowns->where('unit_type', 2);
    $services = $pre_reservation->pre_breakdowns->where('unit_type', 3);
    $layouts = $pre_reservation->pre_breakdowns->where('unit_type', 4);
    $others = $pre_reservation->pre_breakdowns->where('unit_type', 5);
    return view('admin.pre_reservations.show', [
      'pre_reservation' => $pre_reservation,
      'venues' => $venues,
      'equipments' => $equipments,
      'services' => $services,
      'layouts' => $layouts,
      'others' => $others,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $PreReservation = PreReservation::find($id);
    $users = User::all();
    $venues = Venue::all();
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
      $user->id
    ];
  }

  public function edit_update(Request $request, $id)
  {
    DB::transaction(function () use ($request, $id) { //トランザクションさせる
      $pre_reservation = PreReservation::find($id);
      $pre_reservation->update([
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

        'reservation_status' => 0, //デフォで1、仮押さえのデフォは0
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
    return redirect()->route('admin.pre_reservations.index');
  }

  public function switchStatus(Request $request)
  {
    $PreReservation = PreReservation::find($request->pre_reservation_id);
    DB::transaction(function () use ($request, $PreReservation) {
      $PreReservation->update(['status' => 1]);
    });
    $admin = config('app.admin_email');
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
      return redirect()->route('admin.pre_reservations.index')->with('flash_message_error', '仮押さえが選択されていません');
    } else {
      DB::transaction(function () use ($request) { //トランザクションさせる
        foreach ($request->all() as $key => $value) {
          $pre_reservation = PreReservation::find((int)$value);
          if ($pre_reservation) {
            $pre_reservation->delete();
          }
        }
      });
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.index')->with('flash_message', '単発仮押さえの削除が完了しました');
    }
  }
}
