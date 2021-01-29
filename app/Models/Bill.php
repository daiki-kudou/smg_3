<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bill extends Model
{

  use SoftDeletes;

  protected $fillable = [
    'reservation_id',

    'venue_price',

    'equipment_price',

    'layout_price',

    'others_price',

    'master_subtotal',
    'master_tax',
    'master_total',

    'paid',
    'reservation_status',
    'double_check_status',
    'double_check1_name',
    'double_check2_name',
    'approve_send_at',
    'category',
    'admin_judge',
  ];

  /*
|--------------------------------------------------------------------------
| Reservationとの一対多
|--------------------------------------------------------------------------|
*/
  public function reservation()
  {
    return $this->belongsTo(Reservation::class);
  }
  /*
|--------------------------------------------------------------------------
| breakdownsとの一対多
|--------------------------------------------------------------------------|
*/
  public function breakdowns()
  {
    return $this->hasMany(Breakdown::class);
  }

  // breakdowns 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->breakdowns()->get() as $child) {
        $child->delete();
      }
    });
  }
}
