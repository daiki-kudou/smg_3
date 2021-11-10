<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PreReservation;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Venue;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\PaginatorTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPreResToRes;
use App\Service\SendSMGEmail;
use App\Http\Helpers\ReservationHelper;



class PreReservationsController extends Controller
{

  use PaginatorTrait;

  public function __construct()
  {
    $this->middleware(['auth']);
  }


  public function index(Request $request)
  {

    return view('user.pre_reservations.index');
  }

  public function show($id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::find($id);
    if ((int)$pre_reservation->user_id !== $user_id) { //別ユーザーのページ制限
      return redirect(route('user.pre_reservations.index'));
    }
    if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
      return redirect(route('user.pre_reservations.index'));
    }
    $venue = $pre_reservation->venue;
    return view('user.pre_reservations.show', compact('pre_reservation', 'venue'));
  }

  public function calculate(Request $request, $id)
  {
    if ($request->cfm) {
      return $this->cfm($request, $id);
    } else {
      $user_id = auth()->user()->id;
      $pre_reservation = PreReservation::find($id);
      $venue = Venue::find($pre_reservation->venue_id);
      if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
        return redirect(route('user.pre_reservations.index'));
      }
      if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
        return redirect(route('user.pre_reservations.index'));
      }
      $venue_price = $pre_reservation->pre_bill->venue_price;
      $equ_details = !empty($request->all()['equipment_breakdown']) ? $request->all()['equipment_breakdown'] : [];
      $ser_details = !empty($request->all()['services_breakdown']) ? $request->all()['services_breakdown'] : [];
      $item_details = $venue->calculate_items_price($equ_details, $ser_details);
      $layout_details = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean)[2];
      $master = $venue_price + $item_details[0] + $layout_details;
      $user = User::find($pre_reservation->user_id);
      return view(
        'user.pre_reservations.calculate',
        compact('pre_reservation', 'venue', 'request', 'item_details', 'layout_details', 'venue_price', 'master', 'id', 'user')
      );
    }
  }

  public function cfm(Request $request, $id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::with('pre_bill.pre_breakdowns')->find($id);
    if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
      return redirect(route('user.pre_reservations.index'));
    }
    if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
      return redirect(route('user.pre_reservations.index'));
    }
    $user = User::find($request->user_id);
    $payment_limit = $user->getUserPayLimit($request->reserve_date);

    $data = $request->all();
    $data['payment_limit'] = $payment_limit;
    $reservation = new Reservation;
    $bill = new Bill;
    $breakdowns = new Breakdown;
    DB::beginTransaction();
    try {
      // 仮押さえ削除
      $pre_reservation->pre_bill->first()->pre_breakdowns->map(function ($item, $key) {
        return $item->delete();
      });
      $pre_reservation->pre_bill->delete();
      $pre_reservation->delete();

      $result_reservation = $reservation->ReservationStore($data);
      if ($result_reservation === "重複") {
        throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
      }
      $result_bill = $bill->BillStore($result_reservation->id, $data);
      $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      dump($e);
      return back()->withInput()->withErrors($e->getMessage());
    }

    $venue = Venue::find($result_reservation->venue_id);
    $SendSMGEmail = new SendSMGEmail();
    $SendSMGEmail->send("管理者主導仮押えから本予約切り替え（ユーザー承認）", ['reservation_id' => $result_reservation->id, 'bill_id' => $result_bill->id]);

    return redirect(route('user.pre_reservations.show_cfm'));
  }

  public function showCfm()
  {
    return view('user.pre_reservations.cfm');
  }

  public function datatable(Request $request)
  {
    $user = auth()->user()->id;

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
    $_pre_reservations = DB::table('pre_reservations')
      ->select(DB::raw("
        LPAD(pre_reservations.multiple_reserve_id,6,0) as multiple_reserve_id,
        LPAD(pre_reservations.id,6,0) as pre_reservation_id,
        pre_reservations.user_id,
        pre_reservations.status,
        concat(date_format(pre_reservations.created_at, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(pre_reservations.created_at) = 1 then '(日)' 
        when DAYOFWEEK(pre_reservations.created_at) = 2 then '(月)'
        when DAYOFWEEK(pre_reservations.created_at) = 3 then '(火)'
        when DAYOFWEEK(pre_reservations.created_at) = 4 then '(水)'
        when DAYOFWEEK(pre_reservations.created_at) = 5 then '(木)'
        when DAYOFWEEK(pre_reservations.created_at) = 6 then '(金)'
        when DAYOFWEEK(pre_reservations.created_at) = 7 then '(土)'
        end
        ) as created_at,
        concat(date_format(pre_reservations.reserve_date, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(pre_reservations.reserve_date) = 1 then '(日)' 
        when DAYOFWEEK(pre_reservations.reserve_date) = 2 then '(月)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 3 then '(火)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 4 then '(水)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 5 then '(木)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 6 then '(金)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 7 then '(土)'
        end
        ) as reserve_date,
        time_format(pre_reservations.enter_time, '%H:%i') as enter_time,
        time_format(pre_reservations.leave_time, '%H:%i') as leave_time,
        concat(venues.name_area, venues.name_bldg, venues.name_venue) as venue_name,
        pre_reservations.id as original_id,
        case when pre_reservations.reserve_date >= CURRENT_DATE() then 0 else 1 end as 今日以降かどうか,
        case when pre_reservations.reserve_date >= CURRENT_DATE() then reserve_date end as 今日以降日付,
        case when pre_reservations.reserve_date < CURRENT_DATE() then reserve_date end as 今日未満日付
      "))
      ->leftJoin('venues', 'pre_reservations.venue_id', '=', 'venues.id')
      ->whereRaw('pre_reservations.user_id =?', [$user])
      ->whereRaw('pre_reservations.status =?', [1]);


    // 全データの総数
    $totalRecords = $_pre_reservations;

    // 検索があった場合の検索結果の件数
    $totalRecordswithFilter = $_pre_reservations->count();

    // orderリクエストがあれば、orderに沿い、なければ初期並び順指定
    $fix_order_col_name = !empty($request->get('order')) ? $columnName : "今日以降かどうか,今日以降日付,今日未満日付";
    $fix_order_sort_order = !empty($request->get('order')) ? $columnSortOrder : "desc";


    // 検索があった場合の検索結果のcollection
    $records = $_pre_reservations
      ->offset($start)
      ->limit($rowperpage)
      ->orderByRaw("$fix_order_col_name $fix_order_sort_order")
      ->get();

    $data_arr = [];
    foreach ($records as $record) {
      $data_arr[] =
        [
          'multiple_reserve_id' => $record->multiple_reserve_id,
          'pre_reservation_id' => $record->pre_reservation_id,
          'created_at' => $record->created_at,
          'reserve_date' => $record->reserve_date,
          'enter_time' => $record->enter_time,
          'leave_time' => $record->leave_time,
          'venue_name' => $record->venue_name,
          'details' => "<a href=" . url('/user/pre_reservations/' . $record->pre_reservation_id)  . " class='more_btn btn'>詳細</a>"


          // 'reserve_date' => ReservationHelper::formatDate($record->reserve_date),
          // 'enter_time' => ReservationHelper::formatTime($record->enter_time),
          // 'leave_time' => ReservationHelper::formatTime($record->leave_time),
          // 'venue_name' => ($record->venue_name),
          // 'reservation_status' => $this->getSalesStatus($record->reservation_id),
          // 'category' => $this->getSalesCategory($record->reservation_id),
          // 'sogaku' => (int)$record->sogaku < 0 ? "<p style='color:red;'>" . number_format($record->sogaku) . "</p>" : number_format($record->sogaku),
          // 'sales' => $this->getSales($record->reservation_id, $record->sogaku),
          // 'payment_limit' => $this->getPaymentLimit($record->reservation_id),
          // 'paid' => $this->getPaid($record->reservation_id),
          // 'details' => "<a href=" . route('user.home.show', $record->reservation_id) . " class='more_btn btn'>予約<br>詳細</a>",
          // 'invoice' => $this->getInvoice($record->reservation_id),
          // 'receipt' => $this->getReceipt($record->reservation_id),
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

  public function getInvoice($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      if ($b->reservation_status === 3) {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "<a target='_blank' href=" . url('/user/home/invoice/' . $id . '/' . $b->id . '/' . 0)  . " class='more_btn btn'>請求書</a>" .
          "</span>" .
          "</div>" .
          "</li>";
      } else {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "" .
          "</span>" .
          "</div>" .
          "</li>";
      }
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
      if ((int)$reservation->cxls->first()->cxl_status === 2) {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "<a target='_blank' href=" . url('/user/home/invoice/' . $id . '/' . $b->id . '/' . $reservation->cxls->first()->id)  . " class='more_btn btn'>請求書</a>" .
          "</span>" .
          "</div>" .
          "</li>";
      } else {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "" .
          "</span>" .
          "</div>" .
          "</li>";
      }
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }

  public function getReceipt($id)
  {
    $r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
    $result = "";
    foreach ($r as $key => $b) {
      if ($b->paid === 1) {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "<a target='_blank' href=" . url('/user/home/receipt/' . $b->id . '/' . 0)  . " class='more_btn btn'>領収書</a>" .
          "</span>" .
          "</div>" .
          "</li>";
      } else {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "" .
          "</span>" .
          "</div>" .
          "</li>";
      }
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
      if ((int)$reservation->cxls->first()->paid === 1) {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "<a target='_blank' href=" . url('/user/home/receipt/' . $b->id . '/' . $reservation->cxls->first()->id)  . " class='more_btn btn'>領収書</a>" .
          "</span>" .
          "</div>" .
          "</li>";
      } else {
        $result .=
          "<li>" .
          "<div class='multi-column__item'>" .
          "<span class='payment-status'>" .
          "" .
          "</span>" .
          "</div>" .
          "</li>";
      }
    }
    return "<ul class='multi-column__list'>" . $result . "</ul>";
  }
}
