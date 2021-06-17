<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\User;

class ClassHelper
{
  /**   
   *  ユーザーが削除済みであれば、not_memberクラスを付与
   *  @param object $reservation   
   *  @return string
   */
  public static function addNotMemberClass($reservation)
  {
    if ($reservation->user_id > 0) {
      if ($reservation->user->trashed()) {
        return "not_member";
      }
    }
  }
}
