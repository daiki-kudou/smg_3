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
    $thisMonth = Carbon::today();
    $thisMonthvalue = date('Ym', strtotime($thisMonth));
    $thisMonthtext = date('Y年m月', strtotime($thisMonth));
    $nextMonth = $thisMonth->addMonth();
    $nextMonthvalue = date('Ym', strtotime($nextMonth));
    $nextMonthtext = date('Y年m月', strtotime($nextMonth));
    $twoMonthLater = $nextMonth->addMonth();
    $twoMonthLatervalue = date('Ym', strtotime($twoMonthLater));
    $twoMonthLatertext = date('Y年m月', strtotime($twoMonthLater));

    return [
      [$thisMonthvalue, $thisMonthtext],
      [$nextMonthvalue, $nextMonthtext],
      [$twoMonthLatervalue, $twoMonthLatertext]
    ];
  }

  public static function now()
  {
    $now = Carbon::now();
    $now = $now->addDays(3);
    $now = date('Y/m/d', strtotime($now));

    return $now;
  }
}
