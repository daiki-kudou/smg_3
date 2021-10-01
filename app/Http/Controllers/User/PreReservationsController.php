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
use App\Mail\AdminPreResToRes;
use App\Mail\UserPreResToRes;
use App\Service\SendSMGEmail;



class PreReservationsController extends Controller
{

  use PaginatorTrait;

  public function __construct()
  {
    $this->middleware(['auth']);
  }


  public function index(Request $request)
  {
    $user_id = auth()->user()->id;
    // $pre_reservations = PreReservation::where('user_id', $user_id)->where('status', 1)->get();

    $today = Carbon::today();
    $after = PreReservation::where('reserve_date', '>=', $today)->where('user_id', $user_id)->where("status", 1)->get()->sortBy('reserve_date');
    $before = PreReservation::where('reserve_date', '<', $today)->where('user_id', $user_id)->where("status", 1)->get()->sortByDesc('reserve_date');
    $merge = $after->concat($before);
    $pre_reservations = $this->customPaginate($merge, 30, $request);
    $counter = count($pre_reservations);

    return view('user.pre_reservations.index', compact('pre_reservations', 'counter'));
  }

  public function show($id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::find($id);
    if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
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
      $equ_details = $request->all()['equipment_breakdown'];
      $ser_details = $request->all()['services_breakdown'];
      // dd($equ_details, $ser_details);
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
    $SendSMGEmail = new SendSMGEmail($user, $result_reservation, $venue);
    $SendSMGEmail->send("管理者主導仮押えから本予約切り替え（ユーザー承認）");

    return redirect(route('user.pre_reservations.show_cfm'));


    // // 一旦、最新情報でpre reservation を保存。その後予約へ移動
    // DB::transaction(function () use ($id, $request) {
    //   $pre_reservation = PreReservation::find($id);
    //   $pre_reservation->Updates($request);
    //   $pre_bill = new PreBill;
    //   $pre_bill->PreBillCreate($request, $pre_reservation);
    //   $pre_breakdowns = new PreBreakdown;
    //   $pre_breakdowns->PreBreakdownCreate($request, $pre_reservation);
    //   $pre_reservation->MoveToReservation($request);

    //   $admin = explode(',', config('app.admin_email'));
    //   Mail::to($admin) //管理者
    //     ->send(new AdminPreResToRes($pre_reservation));
    //   Mail::to($pre_reservation->user->email) //ユーザー
    //     ->send(new UserPreResToRes($pre_reservation));
    // });
    // return redirect(route('user.pre_reservations.show_cfm'));
  }

  public function showCfm()
  {
    return view('user.pre_reservations.cfm');
  }
}
