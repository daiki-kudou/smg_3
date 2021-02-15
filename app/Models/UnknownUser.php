<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnknownUser extends Model
{
  protected $fillable = [
    'unknown_user_company',
    'unknown_user_name',
    'unknown_user_email',
    'unknown_user_mobile',
    'unknown_user_tel',
  ];

  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }
}
