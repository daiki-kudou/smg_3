<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;
use App\Models\Reservation;

use Session;

class ReservationsController extends Controller
{
  public function create(Request $request)
  {
    $oldSession = $request->session()->get('_old_input');
    if ($oldSession) {
      $request = (object)$oldSession;
      $venue = Venue::with(["frame_prices", "time_prices"])->find($oldSession['venue_id']);
      return view('user.reservations.create', compact('request', 'venue'));
    } else {
      $venue = Venue::with(["frame_prices", "time_prices"])->find($request->venue_id);
      return view('user.reservations.create', compact('request', 'venue'));
    }
  }

  public function check(Request $request)
  {
    $venue = Venue::with('frame_prices')->find($request->venue_id);
    $price_result = $venue->calculate_price($request->price_system, $request->enter_time, $request->leave_time);
    $s_equipment = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
    }

    $s_service = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/services_breakdown/', $key)) {
        $s_service[] = $value;
      }
    }

    $items_results = $venue->calculate_items_price($s_equipment, $s_service);

    $layout_price = 0;
    if ($request->layout_prepare != 0 || $request->layout_clean != 0) {
      if ($request->layout_prepare) {
        $layout_price += $venue->layout_prepare;
      }
      if ($request->layout_clean) {
        $layout_price += $venue->layout_clean;
      }
    }

    $luggage_price = 0;
    if ($request->luggage_count || $request->luggage_arrive || $request->luggage_return) {
      $luggage_price += 500;
    }

    $master = $price_result[2] + $items_results[0] + $layout_price + $luggage_price;

    return view(
      'user.reservations.check',
      compact(
        'request',
        'venue',
        'price_result',
        'items_results',
        'master',
      )
    );
  }

  public function storeSession(Request $request)
  {
    if ($request->back) {
      $arrays = (array)$request->all();
      return redirect()
        ->action("User\ReservationsController@create")
        ->withInput($arrays);
    } else {
      if ($request->select_id) {
        Session::forget('session_reservations.' . $request->select_id);
        Session::get('session_reservations');
      }
      $data = $request->all();
      $user = auth()->user()->id;
      $all_data = [$data, $user];
      $request->session()->push('session_reservations', $all_data);
      return redirect('user/reservations/cart');
    }
  }

  public function cart(Request $request)
  {
    $sessions = $request->session()->get('session_reservations');
    return view('user.reservations.cart', compact('sessions'));
  }

  public function destroy_check(Request $request)
  {
    $sessions = $request->session()->get('session_reservations');
    $session_id = $request->session_reservation_id;
    $slctSession = $sessions[$session_id];
    $venue = Venue::find($slctSession[0]['venue_id']);
    return view('user.reservations.destroy_check', compact('slctSession', 'venue', 'session_id'));
  }

  public function session_destroy(Request $request)
  {
    $session_reservation_id = $request->session_reservation_id;
    Session::forget('session_reservations.' . $session_reservation_id);
    Session::get('session_reservations');
    return redirect('user/reservations/cart');
  }

  public function re_create(Request $request)
  {
    $sessions = $request->session()->get('session_reservations');
    $select_id = $request->session_reservation_id;
    $slctSession = $sessions[$select_id];
    $fix = (object)$slctSession[0];
    $venue = Venue::find($fix->venue_id);
    return view('user.reservations.re_create', compact('fix', 'venue', 'select_id'));
  }

  public function storeReservation(Request $request)
  {
    $sessions = $request->session()->get('session_reservations');
    foreach ($sessions as $key => $value) {
      $reservation = new Reservation();
      $reservation->ReserveFromUser(((object)$value[0]), $value[1]);
    }

    $request->session()->forget('session_reservations');
    $request->session()->regenerate();
    return redirect('user/reservations/complete');
  }

  public function complete()
  {
    return view('user.reservations.complete');
  }
}
