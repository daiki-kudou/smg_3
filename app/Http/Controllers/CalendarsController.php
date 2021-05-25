<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venue;
use App\Models\Reservation;

use Carbon\Carbon;


class CalendarsController extends Controller
{
  public function venue_calendar(Request $request)
  {
    // $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();
    // if ($request->venue_id) {
    //   $selected_venue = $request->venue_id;
    // } else {
    //   $selected_venue = 1;
    // }

    // $days = [];
    // $start_of_month = Carbon::now()->firstOfMonth();
    // $end_of_month = Carbon::now()->endOfMonth();
    // $diff = $start_of_month->diffInDays($end_of_month);
    // for ($i = 0; $i < $diff; $i++) {
    //   $dt = Carbon::now()->firstOfMonth();
    //   $days[] = $dt->addDays($i);
    // }

    // $reservations = Reservation::select('id', 'reserve_date', 'enter_time', 'leave_time', 'reservation_status', 'venue_id', 'user_id')->get();
    // $find_venues = $reservations->where('venue_id', $selected_venue);


    // return view('calendar.venue_calendar', [
    //   'days' => $days,
    //   'venues' => $venues,
    //   'selected_venue' => $selected_venue,
    //   'find_venues' => $find_venues,
    // ]);
  }
}
