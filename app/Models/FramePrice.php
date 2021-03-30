<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FramePrice extends Model
{
  protected $fillable = ['frame', 'start', 'finish', 'price', 'venue_id', 'extend'];

  public function venue()
  {
    return $this->belongsTo(Venue::class);
  }
}
