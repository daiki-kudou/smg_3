<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Venue;
use App\Models\Reservation;

use Carbon\Carbon;


class CalendarsController extends Controller
{
  public function index()
  {
    $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();

    $selected_venue = 1;

    $days = [];
    $start_of_month = Carbon::now()->firstOfMonth();
    $end_of_month = Carbon::now()->endOfMonth();
    $diff = $start_of_month->diffInDays($end_of_month);
    for ($i = 0; $i < $diff; $i++) {
      $dt = Carbon::now()->firstOfMonth();
      $days[] = $dt->addDays($i);
    }

    $reservations = Reservation::select('id', 'reserve_date', 'enter_time', 'leave_time', 'reservation_status', 'venue_id', 'user_id')->get();
    $find_venues = $reservations->where('venue_id', $selected_venue);


    return view('admin.calendar.venue_calendar', [
      'days' => $days,
      'venues' => $venues,
      'selected_venue' => $selected_venue,
      'find_venues' => $find_venues,
      'selected_year'=>Carbon::now()->year,
      'selected_month'=>Carbon::now()->month,
    ]);
  }

  public function getData(Request $request)
  {
    $today = Carbon::now();
    $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();

    $request->venue_id ? $selected_venue = $request->venue_id : $selected_venue = 1;
    $request->selected_year ? $selected_year = $request->selected_year : $selected_year = $today->year;
    $request->selected_month ? $selected_month = $request->selected_month : $selected_month = 1;


    $days = [];
    $start_of_month = Carbon::create($selected_year, $selected_month, 1, 0, 0, 0)->firstOfMonth();
    $end_of_month = Carbon::create($selected_year, $selected_month, 1, 0, 0, 0)->endOfMonth();
    $diff = $start_of_month->diffInDays($end_of_month);
    for ($i = 0; $i < $diff; $i++) {
      $dt = Carbon::create($selected_year, $selected_month, 1, 0, 0, 0)->firstOfMonth();
      $days[] = $dt->addDays($i);
    }

    $reservations = Reservation::select('id', 'reserve_date', 'enter_time', 'leave_time', 'reservation_status', 'venue_id', 'user_id')->get();
    $find_venues = $reservations->where('venue_id', $selected_venue);



    return view('admin.calendar.venue_calendar', [
      'days' => $days,
      'venues' => $venues,
      'selected_venue' => $selected_venue,
      'find_venues' => $find_venues,
      'selected_year' => $selected_year,
      'selected_month' => $selected_month,
    ]);
  }
}
