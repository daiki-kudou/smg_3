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

  public function FramePriceStore($data)
  {
    foreach ($data['price'] as $key => $value) {
      $this->create([
        'frame' => $data['frame'][$key],
        'start' => $data['start'][$key],
        'finish' => $data['finish'][$key],
        'price' => $data['price'][$key],
        'venue_id' => $data['venue_id'],
        'extend' => $data['extend'],
      ]);
    }
  }
}
