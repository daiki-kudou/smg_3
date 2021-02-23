<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreEndUser extends Model
{
  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }
}
