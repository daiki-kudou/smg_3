<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Reservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Equipment;
use App\Models\Service;
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
  public function index(Request $request)
  {
    if (!empty($request->all())) {
      $newInstance = new Reservation();
      $reservations = $newInstance->search_item((object)$request->all());
    } else {
      $reservations = Reservation::all();
    }
    $venue = Venue::all();
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
    } elseif ($layout_prepare == 1 && $layout_clean == 0) {
      $total = $venue->layout_prepare;
    } elseif ($layout_prepare == 0 && $layout_clean == 1) {
      $total = $venue->layout_clean;
    } else {
      $total = 0;
    }

    return [$result, $total];
  }

  /***********************
   * ajax 荷物預り　有り無し　判別
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
  }

  public function calculate(Request $request)
  {

    $users = User::all();
    $venues = Venue::all();
    $spVenue = $venues->find($request->venue_id);
    //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
    $price_details = $spVenue->calculate_price($request->price_system, $request->enter_time, $request->leave_time);
    $s_equipment = Equipment::getArrays($request);
    $s_services = Service::getArrays($request);
    $item_details = $spVenue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
    $layouts_details = $spVenue->getLayoutPrice($request->layout_prepare, $request->layout_clean);
    //枠がなく会場料金を手打ちするパターン
    if ($price_details == 0) {
      $masters =
        ($item_details[0] + $request->luggage_price)
        + $layouts_details[2];
    } else {
      $masters =
        ($price_details[2] ? $price_details[2] : 0)
        + ($item_details[0] + $request->luggage_price)
        + $layouts_details[2];
    }
    $user = $users->find($request->user_id);
    $pay_limit = $user->getUserPayLimit($request->reserve_date);
    return view(
      'admin.reservations.calculate',
      compact('users', 'venues', 'request', 'spVenue', 'price_details', 'item_details', 'layouts_details', 'masters', 'pay_limit')
    );
  }


  public function check(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $venue_details = Venue::getBreakdowns($request);
    $equipment_details = Equipment::getBreakdowns($request);
    $service_details = Service::getBreakdowns($request);
    $others_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/others_input_item/', $key)) {

        if (!empty($value)) {
          $others_details[] = $value;
        }
      }
    }
    $others_details = !empty($others_details) ? count($others_details) : "";
    return view(
      'admin.reservations.check',
      compact('request', 'venue', 'venue_details', 'equipment_details', 'service_details', 'others_details')
    );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $reservation = new Reservation();
    $reservation->ReserveStore($request);
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
    $master_prices = $reservation->TotalAmount();
    $other_bills = [];
    for ($i = 0; $i < count($reservation->bills()->get()) - 1; $i++) {
      $other_bills[] = $reservation->bills()->skip($i + 1)->first();
    }
    return view('admin.reservations.show', compact('venue', 'reservation', 'master_prices', 'user', 'other_bills'));
  }

  public function double_check(Request $request, $id)
  {
    $reservation_bills = Reservation::find($id)->bills()->first();

    if ($request->double_check_status == 0) {
      $reservation_bills->update([
        'double_check1_name' => $request->double_check1_name,
        'double_check_status' => 1
      ]);
    } elseif ($request->double_check_status == 1) {
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
      // 管理者側のメール本文等は未定　ここメール文章再作成必要
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
    $bill = Bill::find($id);
    $reservation = $bill->reservation;
    $venues = Venue::all();
    $venue = $venues->find($reservation->venue_id);
    $users = User::all();

    $checkItem = $bill->checkBreakdowns();
    // [0] 0備品個数　1サービス個数　2レイアウト個数　3その他個数
    // [1] 0会場詳細　1備品詳細　2サービス詳細　3レイアウト詳細　4その他詳細

    // $services = $venues->find($reservation->venue_id)->services()->get();
    // $s_services = [];
    // foreach ($services as $key => $value) {
    //   if ($reservation->bills()->first()->breakdowns()->where('unit_item', $value->item)->first()) {
    //     $s_services[] = 1;
    //   } else {
    //     $s_services[] = 0;
    //   }
    // }

    // $s_layouts = [];
    // if ($reservation->bills()->first()->breakdowns()->where('unit_item', 'レイアウト準備料金')->first()) {
    //   $s_layouts[] = 1;
    // } else {
    //   $s_layouts[] = 0;
    // }
    // if ($reservation->bills()->first()->breakdowns()->where('unit_item', 'レイアウト片付料金')->first()) {
    //   $s_layouts[] = 1;
    // } else {
    //   $s_layouts[] = 0;
    // }

    // $s_luggage = 0;
    // if ($reservation->bills()->first()->breakdowns()->where('unit_item', '荷物預り/返送')->first()) {
    //   $s_luggage = 1;
    // } else {
    //   $s_luggage = 0;
    // }

    // $venue_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 1)->get();
    // $equipments_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 2)->get();
    // $services_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 3)->get();
    // $layouts_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 4)->get();
    // $others_prices = $reservation->bills()->first()->breakdowns()->where('unit_type', 5)->get();

    return view('admin.reservations.edit', [
      'reservation' => $reservation,
      'venues' => $venues,
      'venue' => $venue,
      'users' => $users,
      'bill' => $bill,
      'checkItem' => $checkItem,
      // 'services' => $services,
      // 's_services' => $s_services,
      // 's_layouts' => $s_layouts,
      // 's_luggage' => $s_luggage,
      // 'venue_prices' => $venue_prices,
      // 'equipments_prices' => $equipments_prices,
      // 'services_prices' => $services_prices,
      // 'layouts_prices' => $layouts_prices,
      // 'others_prices' => $others_prices,
    ]);
  }

  public function edit_calculate(Request $request, $id)
  {
    echo "<pre>";

    echo "</pre>";

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
    return view('admin.reservations.edit_calculate', [
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
      'id' => $id,
      'venue' => $venue,
    ]);
  }

  public function edit_check(Request $request, $id)
  {
    echo "<pre>";

    echo "</pre>";
    echo "<pre>";

    echo "</pre>";

    $venue = Venue::find($request->venue_id);
    $venue_details = Venue::getBreakdowns($request);
    $equipment_details = Equipment::getBreakdowns($request);
    $service_details = Service::getBreakdowns($request);
    $others_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/others_input_item/', $key)) {

        if (!empty($value)) {
          $others_details[] = $value;
        }
      }
    }
    $others_details = !empty($others_details) ? count($others_details) : "";

    $equ_breakdowns = Equipment::getBreakdowns($request);
    $ser_breakdowns = Service::getBreakdowns($request);
    return view(
      'admin.reservations.edit_check',
      compact(
        'request',
        'venue',
        'venue_details',
        'equipment_details',
        'service_details',
        'others_details',
        'equ_breakdowns',
        'ser_breakdowns',
        'id'
      )
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

    $reservation = Reservation::find($id);
    $reservation->UpdateReservation($request);
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
