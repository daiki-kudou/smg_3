<?php

namespace App\Traits;


use App\Models\Reservation;
use App\Models\PreReservation;

use Illuminate\Support\Collection;

trait TransactionTrait
{
  /**  
   *予約保存時、入力した入退室時間にかかる予約がすでにあるか検証。   
   *  
   * @param string $reserve_date   
   * @param string $enter_time   
   * @param string $leave_time   
   * @return boolean
   */
  public function checkReservationsTransaction($reserve_date, $enter_time, $leave_time, $venue_id)
  {
    $ary = [];
    $reservations = Reservation::with('bills')
      ->whereDate('reserve_date', $reserve_date)
      ->where('venue_id', $venue_id)
      ->get();
    foreach ($reservations as $key => $value) {
      $temp = [];
      $temp['enter_time'] = $value->enter_time;
      $temp['leave_time'] = $value->leave_time;
      $temp['status'] = $value->bills->first()->reservation_status;
      $ary[] = $temp;
    }
    foreach ($ary as $key => $value) {
      if ($value['status'] <= 3) {
        if ($enter_time < $value['enter_time'] && $leave_time < $value['enter_time']) {
          return TRUE; //入力された開始と終了時間が両方、すでにある予約の開始時間より前
        } elseif ($enter_time > $value['leave_time'] && $leave_time > $value['leave_time']) {
          return TRUE; //入力された開始と終了時間が両方、すでにある予約の開始時間より後
        } else {
          return FALSE;
          break;
        }
      }
    }
    return TRUE;
  }

  /**  
   *予約保存時、入力した入退室時間にかかる仮押さえがすでにあるか検証。   
   *  
   * @param string $reserve_date   
   * @param string $enter_time   
   * @param string $leave_time   
   * @return boolean
   */
  public function checkPreReservationsTransaction($reserve_date, $enter_time, $leave_time, $venue_id)
  {
    $ary = [];
    $pre_reservations = PreReservation::whereDate('reserve_date', $reserve_date)
      ->where('venue_id', $venue_id)
      ->get();
    foreach ($pre_reservations as $key => $value) {
      $temp = [];
      $temp['enter_time'] = $value->enter_time;
      $temp['leave_time'] = $value->leave_time;
      $temp['status'] = $value->status;
      $ary[] = $temp;
    }
    foreach ($ary as $key => $value) {
      if ($value['status'] < 2) {
        if ($enter_time < $value['enter_time'] && $leave_time < $value['enter_time']) {
          return TRUE; //入力された開始と終了時間が両方、すでにある予約の開始時間より前
        } elseif ($enter_time > $value['leave_time'] && $leave_time > $value['leave_time']) {
          return TRUE; //入力された開始と終了時間が両方、すでにある予約の開始時間より後
        } else {
          return FALSE;
          break;
        }
      }
    }
    return TRUE;
  }
}
