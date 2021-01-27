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
    $reservations = Reservation::select(
      'id',
      'reserve_date',
      'enter_time',
      'leave_time',
      'venue_id',
      'user_id',
      'tel',
    )->simplePaginate(15);
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

    $target = $request->all();

    if ($target != null) {
      return view('admin.reservations.create', [
        'venues' => $venues,
        'users' => $users,
        'request' => $request,
      ]);
    } else {
      return view('admin.reservations.create', [
        'venues' => $venues,
        'users' => $users,
      ]);
    }
  }

  public function calculate(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $equipments = $venue->equipments()->get();
    $services = $venue->services()->get();

    //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
    $price_details = $venue->calculate_price(
      $request->price_system,
      $request->enter_time,
      $request->leave_time
    );

    $s_equipment = [];
    $s_services = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipemnt/', $key)) {
        $s_equipment[] = $value;
      }
      if (preg_match('/service/', $key)) {
        $s_services[] = $value;
      }
    }

    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
    $item_details = $venue->calculate_items_price($s_equipment, $s_services);
    $layouts_details = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean);
    $masters = $price_details[2] + ($item_details[0] + $request->luggage_price) + $layouts_details[2];
    $user = User::find($request->user_id);
    $pay_limit = $user->getUserPayLimit($request->reserve_date);


    return view('admin.reservations.calculate', [
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





  public function check(Request $request)
  {
    var_dump($request->all());

    $reserve_date = $request->reserve_date;
    $venue_id = $request->venue_id;
    $venue = Venue::find($venue_id);
    $price_system = $request->price_system;
    $enter_time = $request->enter_time;
    $leave_time = $request->leave_time;
    $board_flag = $request->board_flag;
    $event_start = $request->event_start;
    $event_finish = $request->event_finish;
    $event_name1 = $request->event_name1;
    $event_name2 = $request->event_name2;
    $event_owner = $request->event_owner;
    $user_id = $request->user_id;
    $user = User::find($user_id);
    $in_charge = $request->in_charge;
    $tel = $request->tel;
    $email_flag = $request->email_flag;
    $cost = $request->cost;
    $discount_condition = $request->discount_condition;
    $attention = $request->attention;
    $user_details = $request->user_details;
    $admin_details = $request->admin_details;
    $payment_limit = $request->payment_limit;
    // $paid = $request->paid;
    // $reservation_status = $request->reservation_status;
    // $double_check_status = $request->double_check_status;
    $bill_company = $request->bill_company;
    $bill_person = $request->bill_person;
    $bill_created_at = $request->bill_created_at;
    $bill_pay_limit = $request->bill_pay_limit;
    $layout_prepare = $request->layout_prepare;
    $layout_clean = $request->layout_clean;

    $luggage_count = $request->luggage_count;
    $luggage_arrive = $request->luggage_arrive;
    $luggage_return = $request->luggage_return;
    $luggage_price = $request->luggage_price;

    // $reservation_id = new Reservation;
    $sub_total = $request->sub_total;
    $tax = $request->tax;
    $total = $request->total;

    // 備品の個別入力input
    $simple_v_input = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipemnt/', $key)) {
        $simple_v_input[] = $value;
      }
    }

    // サービスの個別入力input
    $simple_s_input = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/service/', $key)) {
        $simple_s_input[] = $value;
      }
    }

    // 会場の内訳列×４カラム（内容、単価、数量、小計）
    $v_d_counts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/venue_breakdowns/', $key)) {
        $v_d_counts[] = $value;
      }
    }
    // 備品の内訳列×４カラム（内容、単価、数量、小計）
    $e_d_counts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdowns/', $key)) {
        $e_d_counts[] = $value;
      }
    }
    // レイアウトの内訳列×４カラム（内容、単価、数量、小計）
    $l_d_counts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/layout_breakdowns/', $key)) {
        $l_d_counts[] = $value;
      }
    }

    return view('admin.reservations.check', [
      'reserve_date' => $reserve_date,
      'venue_id' => $venue_id,
      'venue' => $venue,
      'price_system' => $price_system,
      'enter_time' => $enter_time,
      'leave_time' => $leave_time,
      'board_flag' => $board_flag,
      'event_start' => $event_start,
      'event_finish' => $event_finish,
      'event_name1' => $event_name1,
      'event_name2' => $event_name2,
      'event_owner' => $event_owner,
      'user_id' => $user_id,
      'user' => $user,
      'in_charge' => $in_charge,
      'tel' => $tel,
      'email_flag' => $email_flag,
      'cost' => $cost,
      'discount_condition' => $discount_condition,
      'attention' => $attention,
      'user_details' => $user_details,
      'admin_details' => $admin_details,
      'payment_limit' => $payment_limit,
      // 'paid' => $paid,
      // 'reservation_status' => $reservation_status,
      // 'double_check_status' => $double_check_status,
      'bill_company' => $bill_company,
      'bill_person' => $bill_person,
      'bill_created_at' => $bill_created_at,
      'bill_pay_limit' => $bill_pay_limit,
      'sub_total' => $sub_total,
      'tax' => $tax,
      'total' => $total,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
      'luggage_count' => $luggage_count,
      'luggage_arrive' => $luggage_arrive,
      'luggage_return' => $luggage_return,
      'luggage_price' => $luggage_price,

      //↓　↓　  備品のinputされた値
      'simple_v_input' => $simple_v_input,
      'simple_s_input' => $simple_s_input,
      //↓　↓　 内訳に記載された会場や、備品、レイアウト等
      'v_d_counts' => $v_d_counts,
      'e_d_counts' => $e_d_counts,
      'l_d_counts' => $l_d_counts,
      'request' => $request
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
    // $this->validate($request, [
    //   'reserve_date' => ['required', 'max:191'],
    //   'venue_id' => ['required', 'max:191'],
    //   'enter_time' => ['required', 'max:191'],
    //   'leave_time' => ['required', 'max:191'],
    //   'board_flag' => ['required', 'max:191'],
    //   'event_start' => ['required', 'max:191'],
    //   'event_finish' => ['required', 'max:191'],
    //   'event_name1' => ['required', 'max:191'],
    //   'event_name2' => ['required', 'max:191'],
    //   'event_owner' => 'required',
    //   'user_id' => 'required',
    //   'in_charge' => 'required',
    //   'tel' => ['required', 'max:191'],
    //   'email_flag' => ['required', 'max:191'],
    //   'cost' => 'required',
    //   'payment_limit' => 'required',
    //   'paid' => 'required',
    //   'reservation_status' => 'required',
    //   'double_check_status' => ['required', 'max:191'],
    //   'bill_company' => 'required',
    //   'bill_person' => 'required',
    //   'bill_created_at' => 'required',
    //   'bill_pay_limit' => 'required',
    // ]);


    DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation = new Reservation;
      $reservation->reserve_date = $request->reserve_date;
      $reservation->venue_id = $request->venue_id;
      $reservation->price_system = $request->price_system;
      $reservation->enter_time = $request->enter_time;
      $reservation->leave_time = $request->leave_time;
      $reservation->board_flag = $request->board_flag;
      $reservation->event_start = $request->event_start;
      $reservation->event_finish = $request->event_finish;
      $reservation->event_name1 = $request->event_name1;
      $reservation->event_name2 = $request->event_name2;
      $reservation->event_owner = $request->event_owner;

      $reservation->luggage_count = $request->luggage_count;
      $reservation->luggage_arrive = $request->luggage_arrive;
      $reservation->luggage_return = $request->luggage_return;

      $reservation->user_id = $request->user_id;
      $reservation->in_charge = $request->in_charge;
      $reservation->tel = $request->tel;
      $reservation->email_flag = $request->email_flag;
      $reservation->cost = $request->cost;
      $reservation->payment_limit = $request->payment_limit;
      // $reservation->paid = $request->paid;
      // $reservation->reservation_status = $request->reservation_status;
      // $reservation->double_check_status = $request->double_check_status;
      $reservation->bill_company = $request->bill_company;
      $reservation->bill_person = $request->bill_person;
      $reservation->bill_created_at = $request->bill_created_at;
      $reservation->bill_pay_limit = $request->bill_pay_limit;
      $reservation->bill_remark = $request->bill_remark;

      $reservation->agent_id = 0; //通常予約のコントローラーからはデフォで0（agent予約ではない）

      $reservation->save();

      $bills = $reservation->bills()->create([
        'reservation_id' => $reservation->id,
        // 会場関連
        'venue_total' => $request->venue_total,
        'venue_discount_percent' => $request->venue_discount_percent, //割引率
        'venue_dicsount_number' => $request->venue_dicsount_number, //割引額
        'discount_venue_total' => $request->discount_venue_total,
        // 備品関連
        'equipment_total' => $request->selected_equipments_price,
        'service_total' => $request->selected_services_price,
        'luggage_total' => $request->selected_luggage_price,
        'equipment_service_total' => $request->selected_items_total,
        'discount_item' => $request->discount_item, //割引額
        'discount_equipment_service_total' => $request->discount_equipment_service_total,
        // レイアウト関連
        'layout_total' => $request->layout_total,
        'layout_discount' => $request->layout_discount, //割引額
        'after_duscount_layouts' => $request->after_duscount_layouts,
        // その他関連
        'others_total' => 0,
        'others_discount' => 0,
        'after_duscount_others' => 0,

        // 該当billの合計額関連
        'sub_total' => $request->sub_total,
        'tax' => $request->tax,
        'total' => $request->total,

        'paid' => 0, //デフォで0 作成時点では未入金
        'reservation_status' => 1, //デフォで1、仮抑えのデフォは0
        'double_check_status' => 0, //デフォで0
        'category' => 1 //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
      ]);
      // 会場料金があれば、会場料金。
      // なければ、手入力された金額が保存
      if ($request->v_breakdowns) {
        foreach ($request->v_breakdowns as $key => $value) {
          $bills->breakdowns()->create([
            'unit_item' => $value['unit_item'],
            'unit_cost' => $value['unit_cost'],
            'unit_count' => $value['unit_count'],
            'unit_subtotal' => $value['unit_subtotal'],
            'unit_type' => $value['unit_type'],
          ]);
        }
      } else {
        if ($request->hand_input_venueprice) {
          $bills->breakdowns()->create([
            'unit_item' => '会場料金',
            'unit_cost' => $request->hand_input_venueprice,
            'unit_count' => $request->hand_input_count,
            'unit_subtotal' => $request->hand_input_subtotal,
            'unit_type' => 1
          ]);
        };
        if ($request->hand_input_extendprice) {
          $bills->breakdowns()->create([
            'unit_item' => '延長料金',
            'unit_cost' => $request->hand_input_extendprice,
            'unit_count' => $request->hand_input_extendcount,
            'unit_subtotal' => $request->hand_input_extendsubtotal,
            'unit_type' => 1
          ]);
        };
        if ($request->hand_input_discountprice) {
          $bills->breakdowns()->create([
            'unit_item' => '割引料金',
            'unit_cost' => $request->hand_input_discountprice,
            'unit_count' => $request->hand_input_discountcount,
            'unit_subtotal' => $request->hand_input_discountsubtotal,
            'unit_type' => 1
          ]);
        };
      };
      // 通常の備品サービス
      if ($request->e_breakdowns) {
        foreach ($request->e_breakdowns as $key => $value) {
          $bills->breakdowns()->create([
            'unit_item' => $value['unit_item'],
            'unit_cost' => $value['unit_cost'],
            'unit_count' => $value['unit_count'],
            'unit_subtotal' => $value['unit_subtotal'],
            'unit_type' => $value['unit_type'],
          ]);
        }
      }
      // 通常のレイアウト
      if ($request->l_breakdowns) {
        foreach ($request->l_breakdowns as $key => $value) {
          $bills->breakdowns()->create([
            'unit_item' => $value['unit_item'],
            'unit_cost' => $value['unit_cost'],
            'unit_count' => $value['unit_count'],
            'unit_subtotal' => $value['unit_subtotal'],
            'unit_type' => $value['unit_type'],
          ]);
        }
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

    return view('admin.reservations.show', [
      'reservation' => $reservation,
      'equipments' => $equipments,
      'services' => $services,
      'breakdowns' => $breakdowns,
      'user' => $user,
      'other_bills' => $other_bills
    ]);
  }

  public function doublecheck(Request $request, $id)
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
    return redirect()->route('admin.reservations.index');
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
    return view('admin.reservations.edit', [
      'reservation' => $reservation,
      'venues' => $venues,
      'users' => $users,
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
