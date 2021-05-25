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

  // 時間制御
  public function control_time(Request $request)
  {
    $reservations = Reservation::with("bills")->where("reserve_date", date('Y-m-d', strtotime($request->date)))
      ->where("venue_id", $request->venue_id)
      ->get();
    $pre_reservations = PreReservation::where('reserve_date', date('Y-m-d', strtotime($request->date)))
      ->where("venue_id", $request->venue_id)
      ->get();
    $result = [];
    foreach ($reservations as $reservation) {
      $diff = (Carbon::parse($reservation->enter_time)->diffInMinutes(Carbon::parse($reservation->leave_time))) / 30;
      $temporary = [];
      for ($i = 0; $i <= $diff; $i++) {
        $temporary[] = date('H:i:00', strtotime(Carbon::parse($reservation->enter_time)->addMinutes($i * 30)));
      }
      $result[] = $temporary;
    }
    foreach ($pre_reservations as $pre_reservation) {
      $diff = (Carbon::parse($pre_reservation->enter_time)->diffInMinutes(Carbon::parse($pre_reservation->leave_time))) / 30;
      $temporary = [];
      for ($i = 0; $i <= $diff; $i++) {
        $temporary[] = date('H:i:00', strtotime(Carbon::parse($pre_reservation->enter_time)->addMinutes($i * 30)));
      }
      $result[] = $temporary;
    }
    return array_merge($result[0], $result[1]);
  }
}
