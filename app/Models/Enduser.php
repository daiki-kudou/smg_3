<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enduser extends Model
{
  protected $fillable = [
    'reservation_id',
    'company',
    'person',
    'address',
    'tel',
    'email',
    'attr',
    'charge',
    'mobile',
  ];

  /*
|--------------------------------------------------------------------------
| 仲介会社経由予約に紐づく予約の参照
|--------------------------------------------------------------------------|
*/
  public function reservation()
  {
    return $this->hasOne(Enduser::class);
    return $this->belongsTo(Reservation::class);
  }
}
