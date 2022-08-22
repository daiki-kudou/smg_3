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
use App\Models\UnknownUser;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserFinPreRes;
// キャンセル
use App\Traits\SearchTrait;
use App\Traits\PaginatorTrait;

// バリデーションロジック
use App\Http\Requests\Admin\PreReservations\Common\VenuePriceRequiredRequest;
use App\Service\SendSMGEmail;

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
    $data = $request->all();
    $_pre_reservations = new PreReservation;
    $_pre_reservations = $_pre_reservations->SearchPreReservation($data)->orderByRaw('予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc')->get()->toArray();
    $counter = count($_pre_reservations);
    $pre_reservations = [];
    foreach ($_pre_reservations as $p) {
      $pre_reservations[] = [
        "<input type='checkbox' name='checkbox" . $p->pre_reservation_id_original . "' value='" . $p->pre_reservation_id_original . "' class='checkbox'>",
        "<a href=" . url('/admin/pre_reservations', $p->pre_reservation_id_original) . " class='more_btn btn'>詳細</a>",
        $p->pre_reservation_id,
        $p->created_at,
        $p->reserve_date,
        $p->enter_time,
        $p->leave_time,
        $p->venue_name,
        $p->company,
        $p->person_name,
        $p->mobile,
        $p->tel,
        $p->unknownuser,
        $p->agent_name,
        $p->enduser,
        ((int)$p->pre_reservation_status === 1 ? "顧" : "S"),
        $p->attention,
      ];
    }

    $pre_reservations = json_encode($pre_reservations);
    $venues = DB::table('venues')->select(DB::raw('id, concat(name_area, name_bldg, name_venue) as venue_name'))->orderByRaw('id desc')->pluck('venue_name', 'id')->toArray();
    $agents = DB::table('agents')->select(DB::raw('id, name'))->orderByRaw('id desc')->pluck('name', 'id')->toArray();

    return view(
      'admin.pre_reservations.index',
      compact('venues', 'agents', 'data', 'pre_reservations', 'counter')
    );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $users = User::orderBy("id", "desc")->get();
    $venues = Venue::orderBy("id", "desc")->get();
    $user_id_from_client_show = $request->user_id_from_client_show;
    return view(
      'admin.pre_reservations.create',
      compact(
        'users',
        'venues',
        'user_id_from_client_show'
      )
    );
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

      if ($multiple->pre_reservations->first()->user_id > 0) {
        return redirect(route('admin.multiples.show', $multiple->id))->with('flash_message', '仮押さえは完了しました');
      } else {
        return redirect(route('admin.multiples.agent_show', $multiple->id));
      }
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
      $users = User::orderBy("id", "desc")->get();
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
    $data = $request->all();
    if ($request->venue_breakdown_item0 || $request->venue_breakdown_cost0 || $request->venue_breakdown_count0 || $request->venue_breakdown_subtotal0) {
      foreach ($request->all() as $key => $value) {
        if (preg_match("/venue_breakdown_item/", $key)) {
          $data['venue_breakdown_item'] = [$value];
        } elseif (preg_match("/venue_breakdown_cost/", $key)) {
          $data['venue_breakdown_cost'] = [$value];
        } elseif (preg_match("/venue_breakdown_count/", $key)) {
          $data['venue_breakdown_count'] = [$value];
        } elseif (preg_match("/venue_breakdown_subtotal/", $key)) {
          $data['venue_breakdown_subtotal'] = [$value];
        }
      }
    }
    $pre_reservation = new PreReservation;
    $pre_bill = new PreBill;
    $pre_breakdown = new PreBreakdown;
    $unknownUser = new UnknownUser;
    DB::beginTransaction();
    try {
      $result_pre_reservation = $pre_reservation->PreReservationStore($data);
      $unknownUser->UnknownUserStore($result_pre_reservation->id, $data);
      $data['end_user_charge'] = 0; //顧客はエンドユーザーへの請求がないため0で固定
      $result_pre_bill = $pre_bill->PreBillStore($result_pre_reservation->id, $data);
      $result_breakdowns = $pre_breakdown->PreBreakdownStore($result_pre_bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.pre_reservations.show', $result_pre_reservation->id);
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
    $users = User::orderBy("id", "desc")->get();

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
      $user->fix_id,
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
        'event_name1' => !empty($request->event_name1)&&!empty($request->board_flag)?$request->event_name1:null,
        'event_name2' => !empty($request->event_name2)&&!empty($request->board_flag)?$request->event_name2:null,
        'event_owner' => !empty($request->event_owner)&&!empty($request->board_flag)?$request->event_owner:null,
        'luggage_count' => $request->luggage_count,
        'luggage_arrive' => $request->luggage_arrive,
        'luggage_return' => $request->luggage_return,
        'luggage_flag' => !empty($request->luggage_flag) ? $request->luggage_flag : 0,
        'email_flag' => $request->email_flag,
        'in_charge' => $request->in_charge,
        'tel' => $request->tel,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        'eat_in' => $request->eat_in,
        'eat_in_prepare' => $request->eat_in_prepare,
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
        'end_user_charge' => 0, //ユーザーからは0で固定
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
    $PreReservation = PreReservation::with(['pre_bill.pre_breakdowns', 'user'])->find($request->pre_reservation_id);

    if ($PreReservation->user_id > 0) {
      DB::transaction(function () use ($request, $PreReservation) {
        $PreReservation->update(['status' => 1]);
      });

      $user = User::find($PreReservation->user->id);
      $venue = Venue::find($PreReservation->venue_id);
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->send("管理者仮押え完了及びユーザーへ編集権限譲渡", $PreReservation->id);

      $flash_message = "顧客に承認権限メールを送りました";
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.show', $request->pre_reservation_id)->with('flash_message', $flash_message);
    } else {
      DB::transaction(function () use ($request, $PreReservation) {
        $PreReservation->update(['status' => 1]);
      });
      $this->moveToReserveFromAgent($PreReservation, $request);
      $flash_message = "予約に移行しました";
      $request->session()->regenerate();
      return redirect()->route('admin.pre_reservations.show', $request->pre_reservation_id)->with('flash_message', $flash_message);
    }
  }

  public function moveToReserveFromAgent($pre_reservation, $request)
  {
    $request = $request->merge([
      'user_id' => 0,
      'enter_time' => $pre_reservation->enter_time,
      'leave_time' => $pre_reservation->leave_time,
      'status' => 2,
      'price_system' => $pre_reservation->price_system,
      'multiple_reserve_id' => $pre_reservation->multiple_reserve_id,
    ]);

    DB::transaction(function () use ($pre_reservation, $request) {
      $pre_reservation->MoveToReservation($request);
    });
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
   * Remove the specified resource from  storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $data = $request->all();
    if (!empty($data['delete_target']) && $data['delete_target'] !== "[]") { //空配列は弾く
      $delete_target_array = json_decode($data['delete_target']); //配列
      DB::beginTransaction();
      try {
        foreach ($delete_target_array as $value) {
          $preReservation = PreReservation::with(['user', 'venue'])->find($value);
          if (is_null($preReservation)) { //削除対象がなければ
            throw new \Exception("ID" . $value . "は存在しません");
          }
          if (($preReservation->user_id > 0)) {
            if (!filter_var($preReservation->user->email, FILTER_VALIDATE_EMAIL)) { //対象がメールアドレスでなければ
              throw new \Exception("ID" . $value . "のメールアドレス" . $preReservation->user->email . "は正しくありません");
            }
          }
        }
        // 上のforeachでメールアドレスチェックをし、全て通ったら再度foreachでメール送信処理
        foreach ($delete_target_array as $v) {
          $preReservation = PreReservation::with(['user', 'venue'])->find($v);
          if ($preReservation->user_id > 0) {
            $SendSMGEmail = new SendSMGEmail();
            $SendSMGEmail->send("管理者が仮抑え一覧よりチェックボックスを選択し削除", $preReservation->id);
          } else {
            $preReservation = PreReservation::with(['user', 'venue'])->find($v);
            $preReservation->delete();
          }
        }
        // 上のメール送信も問題なければ削除
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        return back()->withInput()->withErrors($e->getMessage());
      }
      return redirect()->route('admin.pre_reservations.index')->with('flash_message', 'ユーザーへ削除メールを送付後、自動的に仮押さえを削除します。送付先が複数ある場合、削除までに時差が生じる場合があります');
    } else {
      return redirect()->route('admin.pre_reservations.index')->with('flash_message_error', '仮押えが選択されていません');
    }
  }
}
