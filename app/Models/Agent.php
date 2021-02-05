<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Agent extends Model
{
  /*
|--------------------------------------------------------------------------
| 会場と予約の一対多
|--------------------------------------------------------------------------|
*/
  public function reservations()
  {
    return $this->hasMany(Reservation::class);
  }


  public function searchs($freeword, $id, $name, $person_tel)
  {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('name', 'LIKE', "%$freeword%")
        ->orWhere('person_tel', 'LIKE', "%$freeword%")->paginate(10);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate(10);
    } else if (isset($name)) {
      return $this->where('name', 'LIKE', "%$name%")->paginate(10);
    } else if (isset($person_tel)) {
      return $this->where('person_tel', 'LIKE', "%$person_tel%")->paginate(10);
    } else {
      return $this->query()->paginate(10);
    }
  }

  public function getPayDetails($date)
  {
    $date = Carbon::parse($date);
    $limit = "";
    // 1:当月末　2:翌月末　3:翌々月末
    if ($this->payment_limit == 1) {
      $limit = $date->endOfMonth();
    } elseif ($this->payment_limit == 2) {
      $limit = $date->addMonthsNoOverflow(1);
    } elseif ($this->payment_limit == 3) {
      $limit = $date->addMonthsNoOverflow(2);
    }
    $result = new Carbon($limit);
    return date("Y-m-d", strtotime($result));
  }

  public function agentPriceCalculate($enduser_charge)
  {
    $percent = $this->cost;
    $percent = $percent / 100;
    $result = $enduser_charge - ($enduser_charge * $percent);
    return $result;
  }
}
