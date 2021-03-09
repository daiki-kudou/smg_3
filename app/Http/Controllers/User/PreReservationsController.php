<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PreReservation;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use App\Models\Venue;
use App\Models\User;


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
    $pre_reservation = PreReservation::find($id);
    $authCheck = auth()->user()->CheckAuthRoute($pre_reservation);
    // var_dump($authCheck);
    $venue = $pre_reservation->venue;
    return view('user.pre_reservations.show', compact('pre_reservation', 'venue'));
  }

  public function calculate(Request $request, $id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::find($id);
    $venue = $pre_reservation->venue;
    if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
      return redirect(route('user.pre_reservations.index'));
    }
    if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
      return redirect(route('user.pre_reservations.index'));
    }
    var_dump($request->all());
  }
}
