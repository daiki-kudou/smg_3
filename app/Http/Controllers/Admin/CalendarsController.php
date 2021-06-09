<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Venue;
use App\Models\Reservation;
use App\Models\PreReservation;
use App\Models\Note;

use Carbon\Carbon;

use App\Traits\CalendarTrait;


class CalendarsController extends Controller
{
  use CalendarTrait;

  public function venue_calendar(Request $request)
  {
    $selected_venue = $request->venue_id ? $request->venue_id : 1;
    $fix_input_dates = date('Y-m', strtotime($request->selected_year . '-' . $request->selected_month));
    $start_of_month = $request->all() ? (Carbon::parse($fix_input_dates)->firstOfMonth()) : Carbon::now()->firstOfMonth();
    $end_of_month = $request->all() ? (Carbon::parse($fix_input_dates)->endOfMonth()) : Carbon::now()->endOfMonth();
    $days = $this->venueCalendar($start_of_month, $end_of_month);
    $venues = Venue::all();
    $reservations = Reservation::with('bills')->where('venue_id', $selected_venue)->get();
    $pre_reservations = PreReservation::where("venue_id", $selected_venue)->get();
    return view('admin.calendar.venue_calendar', [
      'days' => $days,
      'venues' => $venues,
      'selected_venue' => $selected_venue,
      'reservations' => $reservations,
      'pre_reservations' => $pre_reservations,
      'selected_year' => !empty($request->selected_year) ? $request->selected_year : Carbon::now()->year,
      'selected_month' => !empty($request->selected_month) ? $request->selected_month : Carbon::now()->month,
    ]);
  }

  public function date_calendar(Request $request)
  {
    $note = Note::all();
    $today = $request->all() ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString();
    $tomorrow = $request->all() ? Carbon::parse($request->date)->addDay()->toDateString() : Carbon::now()->addDay()->toDateString();
    $yesterday = $request->all() ? Carbon::parse($request->date)->addDays(-1)->toDateString() : Carbon::now()->addDays(-1)->toDateString();
    $reservations = Reservation::with('bills')->where('reserve_date', $today)->get();
    $pre_reservations = PreReservation::where('reserve_date', $today)->get();
    $venues = Venue::all();
    $json_result = $this->dateCalendar($reservations);
    $pre_json_result = $this->dateCalendar($pre_reservations);
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
