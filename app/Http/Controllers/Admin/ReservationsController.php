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
use App\Models\Admin;
use App\Models\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; //トランザクション用
use PDF;
use App\Mail\SendUserApprove;
use Illuminate\Support\Facades\Mail;

use App\Traits\PregTrait;
use Illuminate\Support\Facades\Auth;

use App\Traits\PaginatorTrait;
use App\Traits\SortTrait;
use App\Traits\SearchTrait;

class ReservationsController extends Controller
{
  use PregTrait;
  use PaginatorTrait;
  use SortTrait;
  use SearchTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $today = date('Y-m-d', strtotime(Carbon::today()));
    if (!empty($request->all())) {
      $class = new Reservation;
      $result = $class->search_item($request);
      $m_after = $result->where('reserve_date', '>=', $today)->sortBy('reserve_date');
      $m_before = $result->where('reserve_date', '<', $today)->sortByDesc('reserve_date');
      $reservations = $this->customOrderList($m_after, $m_before);
      $counter = $this->exceptSortCount($request->except('_token'), $result);
    } else {
      $m_after = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'endusers', 'venue'])->where('reserve_date', '>=', $today)->get()->sortBy('reserve_date');
      $m_before = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'endusers', 'venue'])->where('reserve_date', '<', $today)->get()->sortByDesc('reserve_date');
      $reservations = $this->customOrderList($m_after, $m_before);
      $counter = 0;
    }
    // ソートのリクエストがあれば
    $reservations = $this->customSearchAndSort($reservations, $request);
    // 最後のページャー
    $reservations = $this->customPaginate($reservations, 30, $request);

    $venues = Venue::all()->toArray();
    $agents = Agent::all()->toArray();
    return view('admin.reservations.index', compact('reservations', 'venues', 'agents', 'counter', 'request'));
  }

  /**
   * reservationが持つbillsでステータスが3以上を抽出
   * 
   * @param object $reservations
   * @return array
   */
  public function rejectCxl($reservations)
  {
    $array = [];
    foreach ($reservations as $key => $value) {
      $judge = $value->bills->every(function ($value, $key) {
        return ($value->reservation_status > 3);
      });
      if ($judge) {
        $array[] = $value->id;
      }
    }
    return $array;
  }

  /**
   * reservationが持つbillsでステータスが3以上を抽出
   * 
   * @param object $m_after
   * @param object $m_before
   * @return object
   */
  public function customOrderList($m_after, $m_before)
  {
    $m_after_reject_cxl = $this->rejectCxl($m_after);
    $m_before_reject_cxl = $this->rejectCxl($m_before);
    $after = $m_after->whereNotIn("id", $m_after_reject_cxl);
    $before = $m_before->whereNotIn("id", $m_before_reject_cxl);
    $reservations = $after->concat($before);
    $after_cxl = $m_after->whereIn("id", $m_after_reject_cxl);
    $before_cxl = $m_before->whereIn("id", $m_before_reject_cxl);
    $cxl = $after_cxl->concat($before_cxl);
    $reservations = $reservations->concat($cxl);
    return $reservations;
  }

  /**
   * 検索の抽出結果をさらに特定の条件でソート
   * 
   * @param object $request
   * @param object $model
   * @return object
   */
  public function customSearchAndSort($model, $request)
  {
    if ($request->sort_multiple_reserve_id) {
      if ($request->sort_multiple_reserve_id == 1) {
        return $model->sortByDesc("multiple_reserve_id");
      } else {
        return $model->sortBy("multiple_reserve_id");
      }
    } elseif ($request->sort_id) {
      if ($request->sort_id == 1) {
        return $model->sortByDesc("id");
      } else {
        return $model->sortBy("id");
      }
    } elseif ($request->sort_reserve_date) {
      if ($request->sort_reserve_date == 1) {
        return $model->sortByDesc("reserve_date");
      } else {
        return $model->sortBy("reserve_date");
      }
    } elseif ($request->sort_enter_time) {
      if ($request->sort_enter_time == 1) {
        return $model->sortByDesc("enter_time");
      } else {
        return $model->sortBy("enter_time");
      }
    } elseif ($request->sort_leave_time) {
      if ($request->sort_leave_time == 1) {
        return $model->sortByDesc("leave_time");
      } else {
        return $model->sortBy("leave_time");
      }
    } elseif ($request->sort_venue) {
      if ($request->sort_venue == 1) {
        return $model->sortByDesc("venue.name_bldg");
      } else {
        return $model->sortBy("venue.name_bldg");
      }
    } elseif ($request->sort_user_company) {
      if ($request->sort_user_company == 1) {
        return $model->sortByDesc("user.company");
      } else {
        return $model->sortBy("user.company");
      }
    } elseif ($request->sort_user_name) {
      if ($request->sort_user_name == 1) {
        return $model->sortByDesc("user.first_name_kana");
      } else {
        return $model->sortBy("user.first_name_kana");
      }
    } elseif ($request->sort_user_mobile) {
      if ($request->sort_user_mobile == 1) {
        return $model->sortByDesc("user.mobile");
      } else {
        return $model->sortBy("user.mobile");
      }
    } elseif ($request->sort_user_tel) {
      if ($request->sort_user_tel == 1) {
        return $model->sortByDesc("user.tel");
      } else {
        return $model->sortBy("user.tel");
      }
    } elseif ($request->sort_agent) {
      if ($request->sort_agent == 1) {
        return $model->sortByDesc("agent.company");
      } else {
        return $model->sortBy("agent.company");
      }
    } elseif ($request->sort_enduser) {
      if ($request->sort_enduser == 1) {
        return $model->sortByDesc("endusers.company");
      } else {
        return $model->sortBy("endusers.company");
      }
    }

    return $model;
  }

  /** ajax 備品orサービス取得*/
  public function geteitems(Request $request)
  {
    $id = $request->venue_id;
    $venue = Venue::find($id);
    $venue_equipments = $venue->equipments()->get();
    $venue_services = $venue->services()->get();
    return [$venue_equipments, $venue_services];
  }

  /** ajax */
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

  /*** ajax 営業時間取得*/
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

  /**** ajax 料金取得****/
  public function getpricedetails(Request $request)
  {
    $venue = Venue::with('frame_prices')->find($request->venue_id);
    $status = $request->status;
    $start = $request->start;
    $finish = $request->finish;

    // $statusは時間枠料金orアクセア料金か判別
    $result = $venue->calculate_price($status, $start, $finish);

    return [$result];
  }

  /*** ajax 備品＆サービス　料金取得   **/
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

  /**** ajax レイアウト有り無し判別取得****/
  public function getlayout(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->layout;

    return [$result];
  }

  /*** ajax レイアウト金額***/
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

  /**** ajax 荷物預り　有り無し　判別****/
  public function getluggage(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->luggage_flag;

    return [$result];
  }

  /**** ajax 直営　or　提携　判別****/
  public function getoperation(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $flag = $venue->alliance_flag;
    $percentage = $venue->cost;
    if ($flag == 0) {
      return [0, ''];
    } else {
      return [1, $percentage];
    }
  }

  /**** ケータリング取得****/
  public function getEatIn(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $eatIn = $venue->eat_in_flag;
    return $eatIn;
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $request->session()->forget(['master_info', 'calc_info', 'reservation', 'bill', 'breakdown']);
    $request->session()->forget('master_info'); //予約作成TOPに来るとsession初期化
    $request->session()->forget('calc_info'); //予約作成TOPに来るとsession初期化
    $request->session()->forget('discount_info'); //予約作成TOPに来るとsession初期化
    $venues = Venue::orderBy("id", "desc")->get();
    $users = User::orderBy("id", "desc")->get();
    $target = $request->all_requests;
    $target = json_decode($target);
    $user_id_from_client_show = $request->user_id_from_client_show;
    return view('admin.reservations.create', compact(
      'venues',
      'users',
      'target',
      'user_id_from_client_show'
    ));
  }

  public function storeSession(Request $request)
  {
    $request->session()->forget('master_info'); //一度あったものを削除
    $request->session()->forget('calc_info'); //一度あったものを削除
    $request->session()->forget('discount_info'); //一度あったものを削除
    $data = $request->all();
    $request->session()->put('master_info', $data);
    $calcData = $this->calcSession($request);
    $request->session()->put('calc_info', $calcData);
    return redirect(route("admin.reservations.calculate"));
  }

  public function calcSession($data)
  {
    $spVenue = Venue::with('frame_prices')->find($data->venue_id);
    // //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
    $price_details = $spVenue->calculate_price($data->price_system, $data->enter_time, $data->leave_time);
    $s_equipment = Equipment::getSessionArrays($data);
    $s_services = Service::getSessionArrays($data);
    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
    $item_details = $spVenue->calculate_items_price($s_equipment, $s_services);
    $layouts_details = $spVenue->getLayoutPrice($data->layout_prepare, $data->layout_clean);
    // //枠がなく会場料金を手打ちするパターン
    if ($price_details == 0) {
      $masters = ($item_details[0] + $data->luggage_price) + $layouts_details[2];
    } else {
      $masters = ($price_details[2] ? $price_details[2] : 0) + ($item_details[0] + $data->luggage_price) + $layouts_details[2];
    }
    $user = User::find($data->user_id);
    $pay_limit = $user->getUserPayLimit($data->reserve_date);
    return [
      'price_details' => $price_details, 'item_details' => $item_details, 'layouts_details' => $layouts_details, 'masters' => $masters, 'pay_limit' => $pay_limit
    ];
  }

  public function calculate(Request $request)
  {
    $value = $request->session()->get('master_info');
    $priceResult = $request->session()->get('calc_info');
    $checkInfo = $request->session()->get('discount_info');

    $users = User::orderBy("id", "desc")->get();
    $venues = Venue::orderBy("id", "desc")->get();

    $spVenue = $venues->find($value['venue_id']);
    return view(
      'admin.reservations.calculate',
      compact(
        'users',
        'venues',
        'request',
        'spVenue',
        'value',
        'priceResult',
        'checkInfo',
      )
    );
  }

  public function checkSession(Request $request)
  {
    $counter = 0;
    foreach ($request->all() as $key => $value) {
      if (preg_match('/venue_breakdown_item/', $key)) {
        $counter++;
      }
    }
    for ($i = 0; $i < $counter; $i++) {
      $v_i = 'venue_breakdown_item' . $i;
      $v_cost = 'venue_breakdown_cost' . $i;
      $v_cnt = 'venue_breakdown_count' . $i;
      $v_s = 'venue_breakdown_subtotal' . $i;
      $test = $this->validate(
        $request,
        [$v_i => ['required'], $v_cost => ['required'], $v_cnt => ['required'], $v_s => ['required']],
        ["{$v_i}.required" => "会場利用料　内容は必須です", "{$v_cost}.required" => "会場利用料　単価は必須です", "{$v_cnt}.required" => "会場利用料　数量は必須です", "{$v_s}.required" => "会場利用料　金額は必須です"]
      );
    }
    $request->session()->forget('discount_info'); //一度あったものを削除
    $data = $request->all();
    $request->session()->put('discount_info', $data);
    return redirect(route("admin.reservations.check"));
  }

  public function check(Request $request)
  {
    $value = $request->session()->get('master_info');
    $priceResult = $request->session()->get('calc_info');
    $checkInfo = $request->session()->get('discount_info');
    $venue = Venue::find($value['venue_id']);

    $v_cnt = $this->preg($checkInfo, "venue_breakdown_item");
    $e_cnt = $this->preg($checkInfo, "equipment_breakdown_item");
    $s_cnt = $this->preg($checkInfo, "services_breakdown_item");
    $o_cnt = $this->preg($checkInfo, "others_breakdown_item");

    return view(
      'admin.reservations.check',
      compact(
        'value',
        'priceResult',
        'checkInfo',
        'venue',
        'v_cnt',
        'e_cnt',
        's_cnt',
        'o_cnt',
      )
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
    try {
      $reservation_store = $reservation->ReserveStoreSession($request, 'master_info', 'discount_info');
      $bill = $reservation_store->ReserveStoreSessionBill($request, "discount_info", 'discount_info');
      $bill->ReserveStoreSessionBreakdown($request, 'discount_info');
    } catch (\Exception $e) {
      session()->flash('flash_message', '更新に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
      return redirect(route('admin.reservations.check'));
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation_store->id);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    session()->forget(['add_bill', 'cxlCalcInfo', 'cxlMaster', 'cxlResult', 'invoice', 'multiOrSingle', 'discount_info', 'calc_info', 'master_info', 'check_info', 'basicInfo', 'reservationEditMaster']);
    $reservation = Reservation::with(['bills.breakdowns', 'cxls.cxl_breakdowns', 'user', 'agent', 'venue', 'change_log'])->find($id);

    $venue = $reservation->venue;
    $user = $reservation->user;
    $master_prices = $reservation->TotalAmount();
    $other_bills = $reservation->bills->sortBy("id")->skip(1);
    $admin = Admin::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'name');
    //付随する追加予約のステータスが予約完了になってるか判別
    $judgeMultiDelete = $reservation->checkBillsStatus();
    $judgeSingleDelete = $reservation->checkSingleBillsStatus();

    $cxl_subtotal = floor($reservation->cxls->pluck('master_subtotal')->sum());
    $cxl_tax = floor($reservation->cxls->pluck('master_tax')->sum());
    $cxl_master_total = floor($reservation->cxls->pluck('master_total')->sum());
    $agentLayoutPrice = $reservation->bills->where('reservation_status', '<=', 3)->pluck('layout_price')->sum();
    $agentPrice = $reservation->bills->where('reservation_status', '<=', 3)->pluck('master_subtotal')->sum();
    $agentPriceWithoutLayout = $agentPrice - $agentLayoutPrice;
    return view(
      'admin.reservations.show',
      compact(
        'venue',
        'reservation',
        'master_prices',
        'user',
        'other_bills',
        "admin",
        'judgeMultiDelete',
        'judgeSingleDelete',
        'cxl_subtotal',
        'cxl_tax',
        'cxl_master_total',
        'agentLayoutPrice',
        'agentPrice',
        'agentPriceWithoutLayout',
      )
    );
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
    $bill = Bill::with(['reservation.user', 'reservation.venue.equipments', 'reservation.venue.services', 'breakdowns'])->find($id);
    $reservation = $bill->reservation;
    $venue = $bill->reservation->venue;
    $users = User::orderBy("id", "desc")->get();

    session()->put('reservationEditMaster', $bill);
    return view('admin.reservations.edit', [
      'reservation' => $reservation,
      'venue' => $venue,
      'bill' => $bill,
      'users' => $users,
    ]);
  }

  public function editWithoutCalc(Request $request)
  {
    $reservationEditMaster = $request->session()->get('reservationEditMaster');

    $bill = $reservationEditMaster;
    $reservation = $bill->reservation;
    $venue = $bill->reservation->venue;
    $users = User::orderBy("id", "desc")->get();
    session()->put('reservationEditMaster', $bill);

    $data = $request->all();
    $request->session()->put('result', $data);
    $result = $request->session()->get('result');
    $v_cnt = $this->preg($result, "venue_breakdown_item");
    $e_cnt = $this->preg($result, "equipment_breakdown_item");
    $s_cnt = $this->preg($result, "services_breakdown_item");
    $o_cnt = $this->preg($result, "others_input_item");
    return view('admin.reservations.edit_without_calc', [
      'reservation' => $reservation,
      'venue' => $venue,
      'bill' => $bill,
      'users' => $users,
      'v_cnt' => $v_cnt,
      'e_cnt' => $e_cnt,
      's_cnt' => $s_cnt,
      'o_cnt' => $o_cnt,
      'result' => $result,
    ]);
  }


  public function sessionForEditCalculate(Request $request)
  {
    $data = $request->all();
    $request->session()->put('basicInfo', $data);
    return redirect(route('admin.reservations.edit_calculate'));
  }

  public function searchPreg($array, $target)
  {
    $result = [];
    foreach ($array as $key => $value) {
      if (preg_match('/' . $target . '/', $key)) {
        $result[] = $value;
      }
    }
    return $result;
  }

  public function getMasterPrice($price_details, $item_details, $layouts_details, $target)
  {
    //枠がなく会場料金を手打ちするパターン
    if ($price_details == 0) {
      $masters =
        ($item_details[0] + ($target['luggage_price'] ?? 0))
        + ($layouts_details[2] ?? 0);
    } else {
      $masters =
        ($price_details[0] ? $price_details[0] : 0)
        + ($item_details[0] + ($target['luggage_price'] ?? 0))
        + ($layouts_details[2] ?? 0);
    }
    return $masters;
  }

  public function edit_calculate(Request $request)
  {
    $basicInfo = $request->session()->get('basicInfo');
    $reservationEditMaster = $request->session()->get('reservationEditMaster');
    $venue = $reservationEditMaster->reservation->venue;
    $users = User::orderBy("id", "desc")->get();
    $price_details = $venue->calculate_price(
      $basicInfo['price_system'],
      $basicInfo['enter_time'],
      $basicInfo['leave_time']
    );
    $s_equipment = $this->searchPreg($basicInfo, 'equipment_breakdown');
    $s_services = $this->searchPreg($basicInfo, 'services_breakdown');
    $item_details = $venue->calculate_items_price($s_equipment, $s_services);
    if (!empty($basicInfo['layout_prepare']) || !empty($basicInfo['layout_clean'])) {
      $layouts_details = $venue->getLayoutPrice($basicInfo['layout_prepare'], $basicInfo['layout_clean']);
    } else {
      $layouts_details = [0, 0];
    }

    $masters = $this->getMasterPrice($price_details, $item_details, $layouts_details, $basicInfo);
    $user = $reservationEditMaster->reservation->user;
    $pay_limit = $user->getUserPayLimit($request->reserve_date);
    return view(
      'admin.reservations.edit_calculate',
      compact(
        'basicInfo',
        'reservationEditMaster',
        'venue',
        'users',
        'price_details',
        'masters',
        'pay_limit',
        'item_details',
        'layouts_details',
      )
    );
  }

  public function sessionForEditCheck(Request $request)
  {
    $data = $request->all();
    $request->session()->put('result', $data);
    return redirect(route('admin.reservations.edit_check'));
  }

  public function edit_check(Request $request)
  {
    $reservationEditMaster = $request->session()->get('reservationEditMaster');
    $venue = $reservationEditMaster->reservation->venue;
    $reservation = $reservationEditMaster->reservation;
    $basicInfo = $request->session()->get('basicInfo');
    $result = $request->session()->get('result');
    $v_cnt = $this->preg($result, "venue_breakdown_item");
    $e_cnt = $this->preg($result, "equipment_breakdown_item");
    $s_cnt = $this->preg($result, "services_breakdown_item");
    $o_cnt = $this->preg($result, "others_breakdown_item");
    return view(
      'admin.reservations.edit_check',
      compact(
        'basicInfo',
        'result',
        'venue',
        'v_cnt',
        'e_cnt',
        's_cnt',
        'o_cnt',
        'reservation',
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
  public function update(Request $request)
  {
    if ($request->back) {
      return redirect(route('admin.reservations.edit_calculate'));
    }
    $reservationEditMaster = $request->session()->get('reservationEditMaster');
    $basicInfo = $request->session()->get('basicInfo');
    $result = $request->session()->get('result');
    try {
      $reservation = $reservationEditMaster->reservation;
      $reservation->UpdateReservation($basicInfo, $result);
      $bill = $reservation->bills->sortBy("id")->first();
      $bill->UpdateBillSession($result);
      $bill->ReserveStoreSessionBreakdown($request, 'result');
    } catch (\Exception $e) {
      report($e);
      session()->flash('flash_message', '更新に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
      return redirect(route('admin.reservations.edit_calculate'));
    }

    $request->session()->regenerate();
    return redirect(route('admin.reservations.show', $reservation->id));
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
