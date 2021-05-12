<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
  protected $fillable = [
    'reservation_id',
    'content',
  ];

  public function reservation()
  {
    return $this->belongsTo('App\Models\Reservation');
  }
}
