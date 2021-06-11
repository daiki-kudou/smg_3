<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

trait CalendarTrait
{
  public function venueCalendar($start_of_month, $end_of_month)
  {
    $days = [];
    $diff = $start_of_month->diffInDays($end_of_month);
    for ($i = 0; $i <= $diff; $i++) {
      $dt = Carbon::parse($start_of_month);
      $days[] = $dt->addDays($i);
    }
    return $days;
  }

  public function dateCalendar($reservations)
  {
    $result = [];
    foreach ($reservations as $key => $reservation) {
      $pre = [];
      $start = Carbon::parse($reservation->enter_time);
      $finish = Carbon::parse($reservation->leave_time);
      $diff = (($start->diffInMinutes($finish)) / 30);
      $pre[] = date('Hi', strtotime($start));
      for ($i = 0; $i < $diff - 1; $i++) { //-1する理由はカレンダーの表記上必要なため
        $pre[] = date('Hi', strtotime($start->addMinutes(30)));
      }
      $result[] = $pre;
    }
    $json_result = json_encode($result, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    return $json_result;
  }
}
