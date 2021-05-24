<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Venue;
use App\Models\Reservation;
use App\Models\PreReservation;

class HomeController extends Controller
{
  public function index()
  {
    $venues = Venue::all();
    return view('home.index', compact('venues'));
  }

  public function slct_date(Request $request)
  {

    $venues = Venue::all();
    return view('home.slct_date', compact('request', 'venues'));
  }

  public function slct_venue(Request $request)
  {
    $venues = Venue::all();
    return view('home.slct_venue', compact('request', 'venues'));
  }

  public function email_reset_done()
  {
    return view('user.home.email_reset_done');
  }

  public function control_time(Request $request)
  {
    $reservation = Reservation::with("bills")->where("reserve_date", date('Y-m-d', strtotime($request->date)))
      ->where("venue_id", $request->venue_id)
      ->get();

    $pre_reservation = PreReservation::where('reserve_date', date('Y-m-d', strtotime($request->date)))
      ->where("venue_id", $request->venue_id)
      ->get();

    return [
      optional($reservation->first())->enter_time,
      optional($reservation->first())->leave_time,
      optional($pre_reservation->first())->enter_time,
      optional($pre_reservation->first())->leave_time
    ];
  }
}
