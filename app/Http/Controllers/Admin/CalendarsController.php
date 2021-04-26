<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Venue;
use App\Models\Reservation;
use App\Models\PreReservation;
use App\Models\Note;

use Carbon\Carbon;


class CalendarsController extends Controller
{
  public function venue_calendar()
  {
    $venues = Venue::all();
    $selected_venue = 1;
    $days = [];
    $start_of_month = Carbon::now()->firstOfMonth();
    $end_of_month = Carbon::now()->endOfMonth();
    $diff = $start_of_month->diffInDays($end_of_month);
    for ($i = 0; $i < $diff; $i++) {
      $dt = Carbon::now()->firstOfMonth();
      $days[] = $dt->addDays($i);
    }
    $reservations = Reservation::where('venue_id', $selected_venue)->get();
    $pre_reservations = PreReservation::where("venue_id", $selected_venue)->get();

    return view('admin.calendar.venue_calendar', [
      'days' => $days,
      'venues' => $venues,
      'selected_venue' => $selected_venue,
      'reservations' => $reservations,
      'pre_reservations' => $pre_reservations,
      'selected_year' => Carbon::now()->year,
      'selected_month' => Carbon::now()->month,
    ]);
  }

  public function venue_calendarGetData(Request $request)
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


  public function date_calendar(Request $request)
  {
    $note = Note::all();
    if (empty($request->all())) {
      $today = Carbon::now()->toDateString();
      $tomorrow = Carbon::now()->addDay()->toDateString();
      $yesterday = Carbon::now()->addDays(-1)->toDateString();
    } else {
      $today = Carbon::parse($request->date)->toDateString();
      $tomorrow = Carbon::parse($request->date)->addDay()->toDateString();
      $yesterday = Carbon::parse($request->date)->addDays(-1)->toDateString();
    }
    $reservations = Reservation::with('bills')->where('reserve_date', $today)->get();
    $venues = Venue::all();

    $result = [];
    foreach ($reservations as $key => $reservation) {
      $pre = [];
      $start = Carbon::parse($reservation->enter_time);
      $finish = Carbon::parse($reservation->leave_time);
      $diff = (($start->diffInMinutes($finish)) / 30);
      $pre[] = date('Hi', strtotime($start));
      for ($i = 0; $i < $diff; $i++) {
        $pre[] = date('Hi', strtotime($start->addMinutes(30)));
      }
      $result[] = $pre;
    }
    $json_result = json_encode($result, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);


    $pre_reservations = PreReservation::where('reserve_date', $today)->get();
    $pre_reservation_result = [];
    foreach ($pre_reservations as $key => $pre_reservation) {
      $pre_pre = [];
      $start = Carbon::parse($pre_reservation->enter_time);
      $finish = Carbon::parse($pre_reservation->leave_time);
      $diff = (($start->diffInMinutes($finish)) / 30);
      $pre_pre[] = date('Hi', strtotime($start));
      for ($i = 0; $i < $diff; $i++) {
        $pre_pre[] = date('Hi', strtotime($start->addMinutes(30)));
      }
      $pre_reservation_result[] = $pre_pre;
    }
    $pre_json_result = json_encode($pre_reservation_result, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

    echo "<pre>";
    var_dump($pre_json_result);
    echo "</pre>";

    return view(
      'admin.calendar.date_calendar',
      compact(
        'reservations',
        'pre_reservations',
        'venues',
        'today',
        'tomorrow',
        'yesterday',
        'json_result',
        'pre_json_result',
        'note',
      )
    );
  }
}
