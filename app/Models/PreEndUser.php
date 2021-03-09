<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreEndUser extends Model
{
  protected $table = 'pre_endusers';

  protected $fillable = [
    'pre_reservation_id',
    'company',
    'person',
    'email',
    'mobile',
    'tel',
    'address',
    'attr',
  ];

  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }
}
