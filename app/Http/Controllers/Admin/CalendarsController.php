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
use DB;


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
    $venues = Venue::all()->sortByDesc('id')->pluck('full_name', 'id');
    $reservations = DB::table('reservations')
      ->select(DB::raw('
      reservations.id,
      reservations.venue_id,
      reservations.enter_time,
      reservations.leave_time,
      reservations.reserve_date,
      bills.reservation_status as reservation_status,
      users.id as user_id,
      case when users.id >0 then users.company when agents.id > 0 then agents.name end as company,
      agents.id as agent_id
    '))
      ->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
      ->whereRaw('reservations.reserve_date between ? and ?', [date('Y-m-d', strtotime($start_of_month)), date('Y-m-d', strtotime($end_of_month))])
      ->whereRaw('reservations.venue_id = ?', [$selected_venue])
      ->whereRaw('reservations.deleted_at is NULL')
      ->groupByRaw('reservations.id, bills.reservation_status')
      ->havingRaw('reservation_status <= ?', [3])
      ->get();
    $pre_reservations =
      DB::table('pre_reservations')
      ->select(DB::raw('
      pre_reservations.multiple_reserve_id as multiple_reserve_id,
      pre_reservations.id,
      pre_reservations.venue_id as venue_id,
      pre_reservations.enter_time,
      pre_reservations.leave_time,
      pre_reservations.reserve_date,
      pre_reservations.status as reservation_status,
      users.id as user_id,
      case when users.id >0 then users.company when agents.id > 0 then agents.name end as company,
      agents.id as agent_id
    '))
      ->leftJoin('pre_bills', 'pre_reservations.id', '=', 'pre_bills.pre_reservation_id')
      ->leftJoin('users', 'pre_reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'pre_reservations.agent_id', '=', 'agents.id')
      ->whereRaw('pre_reservations.reserve_date between ? and ?', [date('Y-m-d', strtotime($start_of_month)), date('Y-m-d', strtotime($end_of_month))])
      ->whereRaw('pre_reservations.venue_id = ?', [$selected_venue])
      ->whereRaw('pre_reservations.status < ?', [2])
      ->get();
    $json_result = $this->dateCalendar($reservations);
    $pre_json_result = $this->dateCalendar($pre_reservations);

    return view('admin.calendar.venue_calendar', [
      'days' => $days,
      'venues' => $venues,
      'selected_venue' => $selected_venue,
      'reservations' => $reservations,
      'pre_reservations' => $pre_reservations,
      'selected_year' => !empty($request->selected_year) ? $request->selected_year : Carbon::now()->year,
      'selected_month' => !empty($request->selected_month) ? $request->selected_month : Carbon::now()->month,
      'json_result' => $json_result,
      'pre_json_result' => $pre_json_result,
    ]);
  }

  public function date_calendar(Request $request)
  {
    $data = $request->all();
    $note = Note::all();
    $today = !empty($data['date']) ? $data['date'] : date('Y-m-d', strtotime(Carbon::today()));
    $tomorrow = $request->all() ? Carbon::parse($request->date)->addDay()->toDateString() : Carbon::now()->addDay()->toDateString();
    $yesterday = $request->all() ? Carbon::parse($request->date)->addDays(-1)->toDateString() : Carbon::now()->addDays(-1)->toDateString();
    // $reservations = Reservation::with('bills')->where('reserve_date', $today)->get();
    $reservations = DB::table('reservations')
      ->select(DB::raw('
      reservations.id,
      reservations.venue_id,
      reservations.enter_time,
      reservations.leave_time,
      reservations.reserve_date,
      bills.reservation_status as reservation_status,
      users.id as user_id,
      case when users.id >0 then users.company when agents.id > 0 then agents.name end as company,
      agents.id as agent_id
    '))
      ->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
      ->whereRaw('reservations.reserve_date = ?', [$today])
      ->whereRaw('reservations.deleted_at is NULL')
      ->groupByRaw('reservations.id, bills.reservation_status')
      ->havingRaw('reservation_status <= ?', [3])
      ->get();

    $pre_reservations =
      DB::table('pre_reservations')
      ->select(DB::raw('
      pre_reservations.multiple_reserve_id as multiple_reserve_id,
      pre_reservations.id,
      pre_reservations.venue_id as venue_id,
      pre_reservations.enter_time,
      pre_reservations.leave_time,
      pre_reservations.reserve_date,
      pre_reservations.status as reservation_status,
      users.id as user_id,
      case when users.id >0 then users.company when agents.id > 0 then agents.name end as company,
      agents.id as agent_id
    '))
      ->leftJoin('pre_bills', 'pre_reservations.id', '=', 'pre_bills.pre_reservation_id')
      ->leftJoin('users', 'pre_reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'pre_reservations.agent_id', '=', 'agents.id')
      ->whereRaw('pre_reservations.reserve_date = ?', [$today])
      ->whereRaw('pre_reservations.status < ?', [2])
      ->get();

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

  public function mini_calendar(Request $request)
  {
    $data = $request->all();
    $note = Note::all();
    $today = !empty($data['date']) ? $data['date'] : date('Y-m-d', strtotime(Carbon::today()));
    $tomorrow = $request->all() ? Carbon::parse($request->date)->addDay()->toDateString() : Carbon::now()->addDay()->toDateString();
    $yesterday = $request->all() ? Carbon::parse($request->date)->addDays(-1)->toDateString() : Carbon::now()->addDays(-1)->toDateString();
    // $reservations = Reservation::with('bills')->where('reserve_date', $today)->get();
    $reservations = DB::table('reservations')
      ->select(DB::raw('
      reservations.id,
      reservations.venue_id,
      reservations.enter_time,
      reservations.leave_time,
      reservations.reserve_date,
      bills.reservation_status as reservation_status,
      users.id as user_id,
      case when users.id >0 then users.company when agents.id > 0 then agents.name end as company,
      agents.id as agent_id
    '))
      ->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
      ->whereRaw('reservations.reserve_date = ?', [$today])
      ->whereRaw('reservations.deleted_at is NULL')
      ->groupByRaw('reservations.id, bills.reservation_status')
      ->havingRaw('reservation_status <= ?', [3])
      ->get();

    $pre_reservations =
      DB::table('pre_reservations')
      ->select(DB::raw('
      pre_reservations.multiple_reserve_id as multiple_reserve_id,
      pre_reservations.id,
      pre_reservations.venue_id as venue_id,
      pre_reservations.enter_time,
      pre_reservations.leave_time,
      pre_reservations.reserve_date,
      pre_reservations.status as reservation_status,
      users.id as user_id,
      case when users.id >0 then users.company when agents.id > 0 then agents.name end as company,
      agents.id as agent_id
    '))
      ->leftJoin('pre_bills', 'pre_reservations.id', '=', 'pre_bills.pre_reservation_id')
      ->leftJoin('users', 'pre_reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'pre_reservations.agent_id', '=', 'agents.id')
      ->whereRaw('pre_reservations.reserve_date = ?', [$today])
      ->whereRaw('pre_reservations.status < ?', [2])
      ->get();

    $venues = Venue::all();
    $json_result = $this->dateCalendar($reservations);
    $pre_json_result = $this->dateCalendar($pre_reservations);

    return view(
      'admin.calendar.mini_calendar',
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
