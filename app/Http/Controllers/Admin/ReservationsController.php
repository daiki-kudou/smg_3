<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Reservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Bill;
use App\Models\Breakdown;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; //トランザクション用
use PDF;
use App\Mail\SendUserApprove;
use Illuminate\Support\Facades\Mail;



class ReservationsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $reservations = Reservation::all();
    $venue = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();
    $user = User::select('id', 'company', 'first_name', 'last_name', 'mobile', 'tel')->get();
    return view('admin.reservations.index', [
      'reservations' => $reservations,
      'venue' => $venue,
      'user' => $user,
    ]);
  }

  /***********************
   * ajax 備品orサービス取得
   **********************
   */
  public function geteitems(Request $request)
  {
    $id = $request->venue_id;
    $venue = Venue::find($id);
    $venue_equipments = $venue->equipments()->get();
    $venue_services = $venue->services()->get();
    return [$venue_equipments, $venue_services];
  }

  /***********************
   * ajax 
   ***********************
   */
  public function getpricesystem(Request $request)
  {
    $id = $request->venue_id; //会場ID
    $dates = Carbon::parse($request->dates); //日付取得
    $week_day = $dates->dayOfWeekIso; //曜日取得

    $venue = Venue::find($id);

    $date = $venue->dates()->where('week_day', $week_day)->get();

    $frame_price = $venue->frame_prices()->get();
    $time_price = $venue->time_prices()->get();

    return [$frame_price, $time_price, $date];
  }

  /***********************
   * ajax 営業時間取得
   ***********************
   */
  public function getsaleshours(Request $request)
  {
    $venue_id = $request->venue_id;
    $dates = $request->dates;

    $reject_targets = [];
    $reservations = Reservation::where('reserve_date', $dates)->where('venue_id', $venue_id)->get();
    foreach ($reservations as $key => $value) {
      $f_start = Carbon::createFromTimeString($value->enter_time, 'Asia/Tokyo');
      $f_finish = Carbon::createFromTimeString($value->leave_time, 'Asia/Tokyo');
      $diff = ($f_finish->diffInMinutes($f_start) / 30);
      for ($i = 0; $i <= $diff; $i++) {
        $reject_targets[] = date('H:i:s', strtotime($f_start . "+ " . (30 * $i) . " min"));
      }
    }
    return [$reject_targets];
    // $venue = Venue::find($request->venue_id);
    // $dates = Carbon::parse($request->dates); //日付取得
    // $week_day = $dates->dayOfWeekIso; //曜日取得
    // $sales_start = Carbon::parse($venue->dates()->where('week_day', $week_day)->first()->start);
    // $sales_finish = Carbon::parse($venue->dates()->where('week_day', $week_day)->first()->finish);

    // return [$sales_start, $sales_finish];
  }

  /***********************
   * ajax 料金取得
   ***********************
   */
  public function getpricedetails(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $status = $request->status;
    $start = $request->start;
    $finish = $request->finish;

    // $statusは時間枠料金orアクセア料金か判別
    $result = $venue->calculate_price($status, $start, $finish);

    return [$result];
  }

  /***********************
   * ajax 備品＆サービス　料金取得
   ***********************
   */
  public function geteitemsprices(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $selected_equipments = $request->equipemnts;
    $selected_services = $request->services;

    $result = $venue->calculate_items_price($selected_equipments, $selected_services);

    // return [$result];
    if (is_null($selected_equipments) && is_null($selected_services)) {
      return fail;
    } else {
      return [$result];
    }
  }

  /***********************
   * ajax レイアウト有り無し判別取得
   ***********************
   */
  public function getlayout(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->layout;

    return [$result];
  }

  /***********************
   * ajax レイアウト金額
   ***********************
   */
  public function getlayoutprice(Request $request)
  {
    $venue = Venue::find($request->venue_id);

    $layout_prepare = $request->layout_prepare;
    $layout_clean = $request->layout_clean;

    $result = [];

    $layout_prepare == 1 ? $result[] = [$venue->layout_prepare, 'レイアウト準備'] : $result[] = '';
    $layout_clean == 1 ? $result[] = [$venue->layout_clean, 'レイアウト片付'] : $result[] = '';

    if ($layout_prepare == 1 && $layout_clean == 1) {
      $total = $venue->layout_prepare + $venue->layout_clean;
    } else if ($layout_prepare == 1 && $layout_clean == 0) {
      $total = $venue->layout_prepare;
    } else if ($layout_prepare == 0 && $layout_clean == 1) {
      $total = $venue->layout_clean;
    } else {
      $total = 0;
    }

    return [$result, $total];
  }

  /***********************
   * ajax 荷物預かり　有り無し　判別
   ***********************
   */
  public function getluggage(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->luggage_flag;

    return [$result];
  }

  /***********************
   * ajax 直営　or　提携　判別
   ***********************
   */
  public function getoperation(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $flag = $venue->alliance_flag;
    $percentage = $venue->cost;
    if ($flag == 0) {
      return 0;
    } else {
      return $percentage;
    }
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $venues = Venue::select('name_area', 'name_bldg', 'name_venue', 'id')->get();
    $users = User::all();

    $target = $request->all_requests;
    $target = json_decode($target);

    // if ($target != null) {
    return view('admin.reservations.create', [
      'venues' => $venues,
      'users' => $users,
      'target' => $target,
    ]);
    // } 
    // else {
    //   return view('admin.reservations.create', [
    //     'venues' => $venues,
    //     'users' => $users,
    //   ]);
    // }
  }

  public function calculate(Request $request)
  {
    $users = User::all();
    $venues = Venue::all();
    $venue = Venue::find($request->venue_id);
    $equipments = $venue->equipments()->get();
    $services = $venue->services()->get();
    $price_details = $venue->calculate_price( //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
      $request->price_system,
      $request->enter_time,
      $request->leave_time
    );
    var_dump($price_details);
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
        ($price_details[2] ? $price_details[2] : 0)
        + ($item_details[0] + $request->luggage_price)
        + $layouts_details[2];
    }
    $user = User::find($request->user_id);
    $pay_limit = $user->getUserPayLimit($request->reserve_date);
    return view('admin.reservations.calculate', [
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

  public function recalculate(Request $request)
  {
    $all_requests = json_decode($request->all_requests, true);
    $venues = Venue::all();
    $venue = $venues->find($all_requests['venue_id']);
    $equipments = $venue->equipments()->get();
    $services = $venue->services()->get();
    $users = User::all();

    $s_equipment = [];
    $s_services = [];
    $s_others = [];
    foreach ($all_requests as $key => $value) {
      if (preg_match('/equipment_breakdown_count/', $key)) {
        $s_equipment[] = $value;
      }
      if (preg_match('/services_breakdown_count/', $key)) {
        $s_services[] = $value;
      }
      if (preg_match('/others_input/', $key)) {
        $s_others[] = $value;
      }
    }
    $price_details = $venue->calculate_price( //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
      $all_requests['price_system'],
      $all_requests['enter_time'],
      $all_requests['leave_time']
    );
    $item_details = json_decode($all_requests['item_details']);

    $layouts_details = json_decode($all_requests['layouts_details']);

    $others_details = json_decode($request->others_details);

    return view('admin.reservations.re_calculate', [
      'all_requests' => $all_requests,
      'venues' => $venues,
      'equipments' => $equipments,
      'services' => $services,
      's_equipment' => $s_equipment,
      's_services' => $s_services,
      's_others' => $s_others,
      'users' => $users,
      'price_details' => $price_details,
      'item_details' => $item_details,
      'layouts_details' => $layouts_details,
      'others_details' => $others_details,
    ]);
  }


  public function check(Request $request)
  {
    var_dump($request->all());
    $venue = Venue::find($request->venue_id);
    $equipments = $venue->equipments()->get();
    $services = $venue->services()->get();

    $items_decode_data = json_decode($request->item_details);
    $s_equipment = $items_decode_data[1];
    $s_services = $items_decode_data[2];

    $venue_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/venue_breakdown/', $key)) {
        $venue_details[] = $value;
      }
    }
    $equipment_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $equipment_details[] = $value;
      }
    }
    $service_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/services_breakdown/', $key)) {
        $service_details[] = $value;
      }
    }
    $others_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/others_input/', $key)) {
        $others_details[] = $value;
      }
    }
    return view('admin.reservations.check', [
      'request' => $request,
      'equipments' => $equipments,
      'services' => $services,
      's_equipment' => $s_equipment,
      's_services' => $s_services,
      'venue_details' => $venue_details,
      'equipment_details' => $equipment_details,
      'service_details' => $service_details,
      'others_details' => $others_details,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {


    DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation = Reservation::create([
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
        'cost' => $request->cost,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        // 'payment_limit' => $request->payment_limit,
        // 'bill_company' => $request->bill_company,
        // 'bill_person' => $request->bill_person,
        // 'bill_created_at' => Carbon::now(),
        // 'bill_remark' => $request->bill_remark,
      ]);

      $bills = $reservation->bills()->create([
        'reservation_id' => $reservation->id,
        'venue_price' => $request->venue_price,
        'equipment_price' => $request->equipment_price ? $request->equipment_price : 0, //備品・サービス・荷物
        'layout_price' => $request->layout_price ? $request->layout_price : 0,
        'others_price' => $request->others_price ? $request->others_price : 0,
        // 該当billの合計額関連
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,

        'payment_limit' => $request->payment_limit,
        'bill_company' => $request->bill_company,
        'bill_person' => $request->bill_person,
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $request->bill_remark,

        'paid' => $request->paid,

        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => $request->payment,

        'reservation_status' => 1, //デフォで1、仮抑えのデフォは0
        'double_check_status' => 0, //デフォで0
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
          $target->breakdowns()->create([
            'unit_item' => $s_arrays[($i * 4)],
            'unit_cost' => $s_arrays[($i * 4) + 1],
            'unit_count' => $s_arrays[($i * 4) + 2],
            'unit_subtotal' => $s_arrays[($i * 4) + 3],
            'unit_type' => $type,
          ]);
        }
      }
      toBreakDown($request->all(), 'venue_breakdown', $bills, 1);
      toBreakDown($request->all(), 'equipment_breakdown', $bills, 2);
      toBreakDown($request->all(), 'service_breakdown', $bills, 3);
      toBreakDown($request->all(), 'others_breakdown', $bills, 5);
      if ($request->luggage_subtotal) {
        $bills->breakdowns()->create([
          'unit_item' => $request->luggage_item,
          'unit_cost' => $request->luggage_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->luggage_subtotal,
          'unit_type' => 3,
        ]);
      }
      if ($request->layout_prepare_subtotal) {
        $bills->breakdowns()->create([
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => $request->layout_prepare_count,
          'unit_subtotal' => $request->layout_prepare_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_subtotal) {
        $bills->breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => $request->layout_clean_count,
          'unit_subtotal' => $request->layout_clean_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_breakdown_discount_item) {
        $bills->breakdowns()->create([
          'unit_item' => $request->layout_breakdown_discount_item,
          'unit_cost' => $request->layout_breakdown_discount_cost,
          'unit_count' => $request->layout_breakdown_discount_count,
          'unit_subtotal' => $request->layout_breakdown_discount_subtotal,
          'unit_type' => 4,
        ]);
      }
    });

    // 戻って再度送信してもエラーになるように設定
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $reservation = Reservation::find($id);
    $venue = Venue::find($reservation->venue->id);
    $user = User::find($reservation->user_id);
    $equipments = $venue->equipments()->get();
    $services = $venue->services()->get();
    $breakdowns = $reservation->breakdowns()->get();

    $other_bills = [];
    for ($i = 0; $i < count($reservation->bills()->get()) - 1; $i++) {
      $other_bills[] = $reservation->bills()->skip($i + 1)->first();
    }

    $venues_master = 0;
    $items_master = 0;
    $layouts_master = 0;
    $others_master = 0;
    $master_subtotals = 0;
    $master_taxs = 0;
    $master_totals = 0;

    foreach ($reservation->bills()->get() as $key => $value) {
      $venues_master += $value->venue_price;
      $items_master += $value->equipment_price;
      $layouts_master += $value->layout_price;
      $others_master += $value->others_price;
      $master_subtotals += $value->master_subtotal;
      $master_taxs += $value->master_tax;
      $master_totals += $value->master_total;
    }

    $all_master_subtotal = $venues_master + $items_master + $layouts_master + $others_master;
    $all_master_tax = floor($all_master_subtotal * 0.1);
    $all_master_total = $all_master_subtotal + $all_master_tax;



    return view('admin.reservations.show', [
      'reservation' => $reservation,
      'equipments' => $equipments,
      'services' => $services,
      'breakdowns' => $breakdowns,
      'user' => $user,
      'other_bills' => $other_bills,
      'venues_master' => $venues_master,
      'items_master' => $items_master,
      'layouts_master' => $layouts_master,
      'others_master' => $others_master,
      'all_master_subtotal' => $all_master_subtotal,
      'all_master_tax' => $all_master_tax,
      'all_master_total' => $all_master_total,
      'master_subtotals' => $master_subtotals,
      'master_taxs' => $master_taxs,
      'master_totals' => $master_totals,

    ]);
  }

  public function double_check(Request $request, $id)
  {
    $reservation_bills = Reservation::find($id)->bills()->first();

    if ($request->double_check_status == 0) {
      $reservation_bills->update([
        'double_check1_name' => $request->double_check1_name,
        'double_check_status' => 1
      ]);
    } else if ($request->double_check_status == 1) {
      $reservation_bills->update([
        'double_check2_name' => $request->double_check2_name,
        'double_check_status' => 2
      ]);
    }
    return redirect('admin/reservations/' . $id);
  }

  public function generate_pdf($id)
  {
    $reservation = Reservation::find($id);

    $pdf = PDF::loadView('admin/reservations/generate_pdf', [
      'reservation' => $reservation
    ])->setPaper('a4', 'landscape');
    return $pdf->stream();
  }

  public function send_email_and_approve(Request $request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation_id = $request->reservation_id;
      $reservation = Reservation::find($reservation_id);
      $reservation->bills()->first()->update(['reservation_status' => 2, 'approve_send_at' => date('Y-m-d H:i:s')]);
      $user = User::find($request->user_id);
      $email = $user->email;
      // 管理者側のメール本文等は未定
      Mail::to($email)->send(new SendUserApprove($reservation));
    });
    return redirect()->route('admin.reservations.index')->with('flash_message', 'ユーザーに承認メールを送信しました');
  }

  public function confirm_reservation(Request $request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation_id = $request->reservation_id;
      $reservation = Reservation::find($reservation_id);
      $reservation->bills()->first()->update(['reservation_status' => 3, 'approve_send_at' => date('Y-m-d H:i:s')]); //固定で3
    });
    return redirect()->route('admin.reservations.index');
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $reservation = Reservation::find($id);
    $venues = Venue::all();
    $users = User::all();
    $services = $venues->find($reservation->venue_id)->services()->get();
    $s_services = [];
    foreach ($services as $key => $value) {
      if ($reservation->bills()->first()->breakdowns()->where('unit_item', $value->item)->first()) {
        $s_services[] = 1;
      } else {
        $s_services[] = 0;
      }
    }

    $s_layouts = [];
    if ($reservation->bills()->first()->breakdowns()->where('unit_item', 'レイアウト準備料金')->first()) {
      $s_layouts[] = 1;
    } else {
      $s_layouts[] = 0;
    }
    if ($reservation->bills()->first()->breakdowns()->where('unit_item', 'レイアウト片付料金')->first()) {
      $s_layouts[] = 1;
    } else {
      $s_layouts[] = 0;
    }

    $s_luggage = 0;
    if ($reservation->bills()->first()->breakdowns()->where('unit_item', '荷物預かり/返送')->first()) {
      $s_luggage = 1;
    } else {
      $s_luggage = 0;
    }

    $venue_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 1)->get();
    $equipments_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 2)->get();
    $services_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 3)->get();
    $layouts_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 4)->get();
    $others_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 5)->get();

    return view('admin.reservations.edit', [
      'reservation' => $reservation,
      'venues' => $venues,
      'users' => $users,
      'services' => $services,
      's_services' => $s_services,
      's_layouts' => $s_layouts,
      's_luggage' => $s_luggage,
      'venue_prices' => $venue_prices,
      'equipments_prices' => $equipments_prices,
      'services_prices' => $services_prices,
      'layouts_prices' => $layouts_prices,
      'others_prices' => $others_prices,
    ]);
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $reservation = Reservation::find($id);
    $reservation->delete();

    return redirect('admin/reservations');
  }
}
