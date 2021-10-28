<?php

namespace App\Http\Helpers;

use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;

use Carbon\Carbon;


class HomeHelper
{
  public static function getMonths()
  {
    $year = 6;
    $result = [];
    $mon = Carbon::now()->startOfMonth();
    for ($i = 0; $i < $year; $i++) {
      $key = date('Ym', strtotime($mon));
      $val = date('Y年m月', strtotime($mon));
      $result[$key] = $val;
      $mon->addMonth();
    }

    return $result;
  }

  public static function now()
  {
    $now = Carbon::now();
    $now = $now->addDays(3);

    return date('Y/m/d', strtotime($now));
  }
}
