<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
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
    // $totalRecordswithFilter = Reservation::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
    $totalRecordswithFilter = $_reservatioin->SearchReservation($request->all())->get()->count();


    // orderリクエストがあれば、orderに沿い、なければ初期並び順指定
    $fix_order_col_name = !empty($request->get('order')) ? $columnName : "予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付";
    $fix_order_sort_order = !empty($request->get('order')) ? $columnSortOrder : "desc";

    // 検索があった場合の検索結果のcollection
    $records = $_reservatioin
      ->SearchReservation($request->all())
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
          'multiple_reserve_id' => ReservationHelper::fixId($record->multiple_reserve_id),
          'reservation_id' => ReservationHelper::fixId($record->reservation_id),
          'reserve_date' => ReservationHelper::formatDate($record->reserve_date),
          'enter_time' => ReservationHelper::formatTime($record->enter_time),
          'leave_time' => ReservationHelper::formatTime($record->leave_time),
          'venue_name' => $record->venue_name,
          'company_name' => $record->company_name,
          'user_name' => $record->user_name,
          'mobile' => $record->mobile,
          'tel' => $record->tel,
          'agent_name' => $record->agent_name,
          'enduser_company' => $record->enduser_company,
          'icon' => $this->getReservationIcon($record->reservation_id),
          'category' => $this->getReservationCategory($record->reservation_id),
          'reservation_status' => $this->getReservationStatus($record->reservation_id),
          'details' => "<a href=" . url('admin/reservations', $record->reservation_id) . " class='more_btn btn'>詳細</a>",
          'board' => $record->board_flag === 1 ? "<a href=" . url('admin/board', $record->reservation_id) . " class='more_btn btn' target='_blank'>詳細</a>" : "",
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
      $result .=
        "<li>" .
        "<div class='multi-column__item'>" .
        "<span class='payment-status'>" .
        str_replace(",", "", implode(",", ImageHelper::addBillsShow($b->id))) .
        "</span>" .
        "</div>" .
        "</li>";
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
        ((int)$b->category === 1 ? "会場予約" : "追加" . $key) .
        "</span>" .
        "</div>" .
        "</li>";
    }

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
}
