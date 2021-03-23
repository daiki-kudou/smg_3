<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PreReservation;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use App\Models\Venue;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Service;


class PreReservationsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth']);
  }


  public function index()
  {
    $user_id = auth()->user()->id;
    $pre_reservations = PreReservation::where('user_id', $user_id)->where('status', 1)->get();
    return view('user.pre_reservations.index', [
      'pre_reservations' => $pre_reservations
    ]);
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
    $equ_details = Equipment::getArrays($request);
    $ser_details = Service::getArrays($request);
    $item_details = $venue->calculate_items_price($equ_details, $ser_details);
    $layout_details = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean)[2];
    $master = $venue_price + $item_details[0] + $layout_details;
    return view(
      'user.pre_reservations.calculate',
      compact('pre_reservation', 'venue', 'request', 'item_details', 'layout_details', 'venue_price', 'master', 'id')
    );
  }

  public function cfm(Request $request, $id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::find($id);
    if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
      return redirect(route('user.pre_reservations.index'));
    }
    if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
      return redirect(route('user.pre_reservations.index'));
    }

    $request = $request->merge([
      'user_id' => $user_id,
      'enter_time' => $pre_reservation->enter_time,
      'leave_time' => $pre_reservation->leave_time,
      'status' => 2,
      'price_system' => $pre_reservation->price_system,
    ]);

    // 一旦、最新情報でpre reservation を保存
    $pre_reservation = PreReservation::find($id);
    $pre_reservation->Updates($request);
    $pre_bill = new PreBill;
    $pre_bill->PreBillCreate($request, $pre_reservation);
    $pre_breakdowns = new PreBreakdown;
    $pre_breakdowns->PreBreakdownCreate($request, $pre_reservation);


    $pre_reservation->MoveToReservation($request);

    // return view('user.pre_reservations.cfm');
  }
}
