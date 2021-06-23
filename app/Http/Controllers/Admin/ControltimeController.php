<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Reservation;
use App\Models\PreReservation;
use Carbon\Carbon; //carbon利用



class ControltimeController extends Controller
{
  public function getInformation(Request $request)
  {
    $date = $request->date;
    $venue_id = $request->venue_id;
    $reservations = Reservation::with('bills')->whereDate('reserve_date', $date)->where('venue_id', $venue_id)->get();
    $pre_reservations = PreReservation::whereDate('reserve_date', $date)
      ->where('venue_id', $venue_id)
      ->where('status', '<', 2)
      ->get();
    $result = $this->getTimes($reservations, $pre_reservations);
    return $result;
  }

  public function getTimes($reservations, $pre_reservations)
  {
    $timeArray = [];
    foreach ($reservations as $key => $value) {
      if ($value->bills->sortBy("id")->first()->reservation_status <= 3) { //キャンセルプロセスにあるものは除外
        $f_start = Carbon::createFromTimeString($value->enter_time, 'Asia/Tokyo');
        $f_finish = Carbon::createFromTimeString($value->leave_time, 'Asia/Tokyo');
        $diff = ($f_finish->diffInMinutes($f_start) / 30);
        for ($i = 0; $i <= $diff; $i++) {
          $timeArray[] = date('H:i:s', strtotime($f_start . "+ " . (30 * $i) . " min"));
        }
      }
    }
    foreach ($pre_reservations as $key => $value) {
      $f_start = Carbon::createFromTimeString($value->enter_time, 'Asia/Tokyo');
      $f_finish = Carbon::createFromTimeString($value->leave_time, 'Asia/Tokyo');
      $diff = ($f_finish->diffInMinutes($f_start) / 30);
      for ($i = 0; $i <= $diff; $i++) {
        $timeArray[] = date('H:i:s', strtotime($f_start . "+ " . (30 * $i) . " min"));
      }
    }
    return $timeArray;
  }
}
