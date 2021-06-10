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
    $today = date("Y/m/d", strtotime(Carbon::now()));

    return view('home.slct_date', compact('request', 'venues', 'today'));
  }


  public function slct_venue(Request $request)
  {
    $venues = Venue::all();
    $selected_venue = $request->room04 ? $request->room04 : 1;
    return view('home.slct_venue', compact('request', 'venues', 'selected_venue'));
  }

  public function email_reset_done()
  {
    return view('user.home.email_reset_done');
  }

  // 時間制御
  public function control_time(Request $request)
  {
    // 営業時間抽出
    $salesHours = $this->getSalesHours($request);
    // 該当日時の予約・仮抑え　抽出
    $reservations_or_pre_reservations = $this->getReservations($request);
    if ($reservations_or_pre_reservations) {
      foreach ($salesHours[0] as $key => $value) { //元の時間08~23時
        if (in_array($value['time'], $reservations_or_pre_reservations)) {
          $salesHours[0][$key]['active'] = 0;
        }
      }
      return $salesHours[0];
    } else {
      return $salesHours[0];
    }
  }

  public function getSalesHours($request)
  {
    $venue = Venue::with("dates")->find($request->venue_id);
    $weekday = Carbon::parse($request->date)->dayOfWeek == 0 ? 7 : Carbon::parse($request->date)->dayOfWeek;
    $venue_date = $venue->dates->where("week_day", $weekday)->first();
    $start = $venue_date->start;
    $finish = $venue_date->finish;
    $diff = (Carbon::parse($start)->diffInMinutes(Carbon::parse($finish))) / 30;
    $temporary = [];
    for ($i = 0; $i <= $diff; $i++) {
      $temporary[] =  [
        'active' => 1,
        "time" => date('H:i:00', strtotime(Carbon::parse($start)->addMinutes($i * 30))),
        "value" => date('H:i', strtotime(Carbon::parse($start)->addMinutes($i * 30)))
      ];
    }
    $times[] = $temporary;
    return $times;
  }

  public function getReservations($request)
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
    if (count($result) === 1) {
      return $result[0];
    } elseif (count($result) === 2) {
      return array_merge($result[0], $result[1]);
    } else {
      return  [];
    }
  }

  public function cxl_member_ship_done()
  {
    return view('home.cxl_membership_done');
  }
}
