<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\PreReservation;
use DB;
use App\Http\Helpers\ReservationHelper;
use App\Http\Helpers\ImageHelper;



class DataTableController extends Controller
{
  public function reservation(Request $request)
  {
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page 


    if (!empty($request->get('order'))) {
      $columnIndex_arr = $request->get('order');
      $columnIndex = $columnIndex_arr[0]['column']; // Column index 
    }

    if (!empty($request->get('order'))) {
      $columnName_arr = $request->get('columns');
      $columnName = $columnName_arr[$columnIndex]['data']; // Column name 
    }

    if (!empty($request->get('order'))) {
      $order_arr = $request->get('order');
      $columnSortOrder = $order_arr[0]['dir']; // asc or desc 
    }

    if (!empty($request->get('order'))) {
      $search_arr = $request->get('search');
      $searchValue = $search_arr['value']; // Search value 
    }

    // Total records 
    $_reservatioin = new Reservation;
    // 全データの総数
    $totalRecords = $_reservatioin->ReservationSearchTarget();

    // 検索があった場合の検索結果の件数
    $totalRecordswithFilter = $_reservatioin->SearchReservation($request->all())->get()->count();

    // orderリクエストがあれば、orderに沿い、なければ初期並び順指定
    $fix_order_col_name = !empty($request->get('order')) ? $columnName : "予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付";
    $fix_order_sort_order = !empty($request->get('order')) ? $columnSortOrder : "desc";

    // 検索があった場合の検索結果のcollection
    $records = $_reservatioin
      ->SearchReservation($request->all())
      ->offset($start)
      ->limit($rowperpage)
      ->orderByRaw("$fix_order_col_name $fix_order_sort_order")
      ->get();

    $data_arr = [];
    foreach ($records as $record) {
      $data_arr[] =
        [
          'multiple_reserve_id' => "<div>" . ReservationHelper::fixId($record->multiple_reserve_id) . "</div>",
          'reservation_id' => "<div>" . ReservationHelper::fixId($record->reservation_id) . "</div>",
          'reserve_date' => "<div>" . ReservationHelper::formatDate($record->reserve_date) . "</div>",
          'enter_time' => "<div>" . ReservationHelper::formatTime($record->enter_time) . "</div>",
          'leave_time' => "<div>" . ReservationHelper::formatTime($record->leave_time) . "</div>",
          'venue_name' => "<div>" . $record->venue_name . "</div>",
          'company_name' => "<div>" . $record->company_name . "</div>",
          'user_name' => "<div>" . $record->user_name . "</div>",
          'mobile' => "<div>" . $record->mobile . "</div>",
          'tel' => "<div>" . $record->tel . "</div>",
          'agent_name' => "<div>" . $record->agent_name . "</div>",
          'enduser_company' => "<div>" . $record->enduser_company . "</div>",
          'icon' => "<div>" . $this->getReservationIcon($record->reservation_id) . "</div>",
          'category' => "<div>" . $this->getReservationCategory($record->reservation_id) . "</div>",
          'reservation_status' => "<div>" . $this->getReservationStatus($record->reservation_id) . "</div>",
          'details' => "<div>" . "<a href=" . url('admin/reservations', $record->reservation_id) . " class='more_btn btn'>詳細</a>" . "</div>",
          'board' => "<div>" . ((int)$record->board_flag === 1 ? ("<a href=" . url('admin/board', $record->reservation_id) . " class='more_btn btn' target='_blank'>詳細</a>") : "") . "</div>",
        ];
    }

    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
  }

  public function getReservationIcon($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      if ($key === 0) {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          str_replace(",", "", implode(",", ImageHelper::show($id))) .
          "</span>" .
          "</div>" .
          "</li>";
      } else {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          str_replace(",", "", implode(",", ImageHelper::addBillsShow($b->id))) .
          "</span>" .
          "</div>" .
          "</li>";
      }
    }

    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }


  public function getReservationCategory($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ((int)$b->category === 1 ? "会場予約" : "追加請求" . $key) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getReservationStatus($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ReservationHelper::judgeStatus($b->reservation_status) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }


  // 以下売上請求一覧


  public function sales(Request $request)
  {
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page 


    if (!empty($request->get('order'))) {
      $columnIndex_arr = $request->get('order');
      $columnIndex = $columnIndex_arr[0]['column']; // Column index 
    }

    if (!empty($request->get('order'))) {
      $columnName_arr = $request->get('columns');
      $columnName = $columnName_arr[$columnIndex]['data']; // Column name 
    }

    if (!empty($request->get('order'))) {
      $order_arr = $request->get('order');
      $columnSortOrder = $order_arr[0]['dir']; // asc or desc 
    }

    if (!empty($request->get('order'))) {
      $search_arr = $request->get('search');
      $searchValue = $search_arr['value']; // Search value 
    }

    // Total records 
    $_reservatioin = new Reservation;
    // 全データの総数
    $totalRecords = $_reservatioin->ReservationSearchTarget();

    // 検索があった場合の検索結果の件数
    $totalRecordswithFilter = $_reservatioin->SearchReservation($request->all())->get()->count();

    // orderリクエストがあれば、orderに沿い、なければ初期並び順指定
    $fix_order_col_name = !empty($request->get('order')) ? $columnName : "予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付";
    $fix_order_sort_order = !empty($request->get('order')) ? $columnSortOrder : "desc";

    // 検索があった場合の検索結果のcollection
    $records = $_reservatioin
      ->SearchReservation($request->all())
      ->offset($start)
      ->limit($rowperpage)
      ->orderByRaw("$fix_order_col_name $fix_order_sort_order")
      ->get();

    $data_arr = [];
    foreach ($records as $record) {
      $data_arr[] =
        [
          'multiple_reserve_id' => ReservationHelper::fixId($record->multiple_reserve_id),
          'reservation_id' => ReservationHelper::fixId($record->reservation_id),
          'reserve_date' => ReservationHelper::formatDate($record->reserve_date),
          'venue_name' => ($record->venue_name),
          'user_id' => ReservationHelper::fixId($record->user_id),
          'company_name' => $record->company_name,
          'user_name' => $record->user_name,
          'agent_name' => $record->agent_name,
          'enduser_company' => $record->enduser_company,
          'sogaku' => (int)$record->sogaku < 0 ? "<p style='color:red;'>" . number_format($record->sogaku) . "</p>" : number_format($record->sogaku),
          'sales' => $this->getSales($record->reservation_id, $record->sogaku),
          'cost' => $this->getCost($record->reservation_id),
          'profit' => $this->getProfit($record->reservation_id),
          'category' => $this->getSalesCategory($record->reservation_id),
          'reservation_status' => $this->getSalesStatus($record->reservation_id),
          'paid' => $this->getPaid($record->reservation_id),
          'payment_limit' => $this->getPaymentLimit($record->reservation_id),
          'pay_day' => $this->getPayDay($record->reservation_id),
          'details' => "<a href=" . url('admin/reservations', $record->reservation_id) . " class='more_btn btn'>詳細</a>",
          'pay_person' => $this->getPayPerson($record->reservation_id),
          'attr' => ReservationHelper::getAttr($record->attr),
          'alliance_flag' => (int)$record->alliance_flag === 0 ? '直' : '提',
        ];
    }

    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
  }

  public function getSales($id, $sogaku = 0)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status' style='" . ((int)$b->master_total < 0 ? "color:red" : "") . "'>" .
        number_format(((int)$b->master_total)) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        number_format(-$sogaku) .
        "</span>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status' style='" . ((int)$reservation->cxls->first()->master_total < 0 ? "color:red;" : "") . "'>" .
        number_format((int)$reservation->cxls->first()->master_total) .
        "</span>" .
        "</div>" .
        "</li>";
    }

    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getCost($id)
  {
    $reservation = Reservation::with('venue')->find($id);
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        number_format($reservation->venue->getCostForPartner($reservation->venue, $b->master_total, $b->layout_price, $reservation)) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        number_format(- ($reservation->venue->sumCostForPartner($reservation))) .
        "</span>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        number_format($reservation->venue->getCxlCostForPartner($reservation)) .
        "</span>" .
        "</div>" .
        "</li>";
    }

    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getProfit($id, $sogaku = 0)
  {
    $reservation = Reservation::with('venue')->find($id);
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    $sumProfit = 0;
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status' style='" . ($reservation->venue->getProfitForPartner($reservation->venue, $b->master_total, $b->layout_price, $reservation) < 0 ? "color:red;" : "") . "'>" .
        number_format($reservation->venue->getProfitForPartner($reservation->venue, $b->master_total, $b->layout_price, $reservation)) .
        "</span>" .
        "</div>" .
        "</li>";
      $sumProfit += (int)($reservation->venue->getProfitForPartner($reservation->venue, $b->master_total, $b->layout_price, $reservation));
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        number_format(-$sumProfit) .
        "</span>" .
        "</div>" .
        "</li>";

      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status' style='" . ((int)(((int)$reservation->cxls->first()->master_total) - ($reservation->venue->getCxlCostForPartner($reservation))) < 0 ? "color:red" : "") . "'>" .
        number_format(((int)$reservation->cxls->first()->master_total) - ($reservation->venue->getCxlCostForPartner($reservation))) .
        "</span>" .
        "</div>" .
        "</li>";
    }

    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getSalesCategory($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ((int)$b->category === 1 ? "会場予約" : "追加請求" . $key) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        "打消" .
        "</span>" .
        "</div>" .
        "</li>";

      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        "キャンセル料" .
        "</span>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getSalesStatus($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ReservationHelper::judgeStatus($b->reservation_status) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        "-" .
        "</span>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        (ReservationHelper::cxlStatus($reservation->cxls->first()->cxl_status)) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }
  public function getPayDay($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ReservationHelper::formatDate($b->pay_day) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        "-" .
        "</span>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        (ReservationHelper::formatDate($reservation->cxls->first()->pay_day)) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getPaid($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ReservationHelper::paidStatus($b->paid) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        "-" .
        "</span>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        (ReservationHelper::paidStatus($reservation->cxls->first()->paid)) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getPayPerson($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<p class='text-limit'>" .
        ($b->pay_person) .
        "</p>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<p class='text-limit'>" .
        "-" .
        "</p>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<p class='text-limit'>" .
        ($reservation->cxls->first()->pay_person) .
        "</p>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }
  public function getPaymentLimit($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ReservationHelper::formatDate($b->payment_limit) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    $reservation = Reservation::with('cxls')->find($id);
    if ($reservation->cxls->count() > 0) {
      // 打ち消し表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status text-danger'>" .
        "-" .
        "</span>" .
        "</div>" .
        "</li>";
      // キャンセル料表示
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        ReservationHelper::formatDate($reservation->cxls->first()->payment_limit) .
        "</span>" .
        "</div>" .
        "</li>";
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }



  // 仮抑え


  public function pre_reservations(Request $request)
  {
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page 


    if (!empty($request->get('order'))) {
      $columnIndex_arr = $request->get('order');
      $columnIndex = $columnIndex_arr[0]['column']; // Column index 
    }

    if (!empty($request->get('order'))) {
      $columnName_arr = $request->get('columns');
      $columnName = $columnName_arr[$columnIndex]['data']; // Column name 
    }

    if (!empty($request->get('order'))) {
      $order_arr = $request->get('order');
      $columnSortOrder = $order_arr[0]['dir']; // asc or desc 
    }

    if (!empty($request->get('order'))) {
      $search_arr = $request->get('search');
      $searchValue = $search_arr['value']; // Search value 
    }

    // Total records 
    $_pre_reservatioin = new PreReservation;
    // 全データの総数
    $totalRecords = $_pre_reservatioin->PreReservationSearchTarget();

    // 検索があった場合の検索結果の件数
    // $totalRecordswithFilter = Reservation::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
    $totalRecordswithFilter = $_pre_reservatioin->SearchPreReservation($request->all())->get()->count();


    // orderリクエストがあれば、orderに沿い、なければ初期並び順指定
    $fix_order_col_name = !empty($request->get('order')) ? $columnName : "予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付";
    $fix_order_sort_order = !empty($request->get('order')) ? $columnSortOrder : "desc";

    // 検索があった場合の検索結果のcollection
    $records = $_pre_reservatioin
      ->SearchPreReservation($request->all())
      ->offset($start)
      ->limit($rowperpage)
      // ->orderByRaw('予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc')
      ->orderByRaw("$fix_order_col_name $fix_order_sort_order")
      ->get();

    $data_arr = [];
    $sno = $start + 1;
    foreach ($records as $record) {
      $data_arr[] =
        [
          'checkbox' => '<input type="checkbox" name="" value="" class="checkbox" >',
          'pre_reservation_id' => $record->pre_reservation_id,
          'created_at' => $record->created_at,
          'reserve_date' => $record->reserve_date,
          'enter_time' => $record->enter_time,
          'leave_time' => $record->leave_time,
          'venue_name' => $record->venue_name,
          'company' => $record->company,
          'person_name' => $record->person_name,
          'mobile' => $record->mobile,
          'tel' => $record->tel,
          'unknownuser' => $record->unknownuser,
          'agent_name' => $record->agent_name,
          'enduser' => $record->enduser,
          'details' => "<a href=" . url('admin/pre_reservations', $record->pre_reservation_id_original) . " class='more_btn btn'>詳細</a>",
        ];
    }

    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
  }
}
