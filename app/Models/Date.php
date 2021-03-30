<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{

  protected $fillable = ['start', 'finish', 'week_day', 'venue_id'];
  // protected $dates = ['start', 'finish']; //formatで使用できるようにするため


  public function venues()
  {
    return $this->belongsTo('App\Models\Venue')->withTimestamps();
  }

  public static function dateUpdates($venue_id, $weekday_id, $start, $finish)
  {
    $date = self::where('venue_id', $venue_id)->where('week_day', $weekday_id);
    return $date->update(['start' => $start, 'finish' => $finish]);
  }
}
