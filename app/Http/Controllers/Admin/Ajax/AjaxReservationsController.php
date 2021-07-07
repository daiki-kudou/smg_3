<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use Carbon\Carbon;

class AjaxReservationsController extends Controller
{
  public function get_items(Request $request)
  {
    $id = $request->venue_id;
    $venue = Venue::find($id);
    $venue_equipments = $venue->equipments()->get();
    $venue_services = $venue->services()->get();
    return [$venue_equipments, $venue_services];
  }

  public function get_price_system(Request $request)
  {
    $id = $request->venue_id; //会場ID
    $dates = Carbon::parse($request->dates); //日付取得
    $week_day = $dates->dayOfWeekIso; //曜日取得
    $venue = Venue::find($id);
    $date = $venue->dates()->where('week_day', $week_day)->get();
    $frame_price = $venue->frame_prices()->get();
    $time_price = $venue->time_prices()->get();
    return [$frame_price, $time_price, $date];
  }

  public function get_layout(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->layout;
    return [$result];
  }

  public function get_luggage(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->luggage_flag;
    return [$result];
  }

  public function get_eat_in(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $eatIn = $venue->eat_in_flag;
    return $eatIn;
  }

  public function get_operation_system(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $flag = $venue->alliance_flag;
    $percentage = $venue->cost;
    if ($flag == 0) {
      return [0, ''];
    } else {
      return [1, $percentage];
    }
  }
}
