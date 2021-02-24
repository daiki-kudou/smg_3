<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreEndUser extends Model
{
  protected $fillable = [
    'company',
    'person',
    'email',
    'mobile',
    'tel',

  ];
  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }
}
