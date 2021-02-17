<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleReserve extends Model
{
  /*
|--------------------------------------------------------------------------
| pre reservation 一対多
|--------------------------------------------------------------------------|
*/
  public function pre_reservations()
  {
    return $this->hasMany(PreReservation::class);
  }
}
