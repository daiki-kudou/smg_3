<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimePrice extends Model
{
  protected $fillable = ['time', 'price', 'extend', 'venue_id'];

  public function venue()
  {
    return $this->belongsTo(Venue::class);
  }
}
