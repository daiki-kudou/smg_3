<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreBill extends Model
{
  protected $fillable = [
    'pre_reservation_id',

    'venue_price',

    'equipment_price',

    'layout_price',

    'others_price',

    'master_subtotal',
    'master_tax',
    'master_total',

    // 'payment_limit',
    // 'bill_company',
    // 'bill_person',
    // 'bill_created_at',
    // 'bill_remark',

    // 'paid',
    // 'pay_day',
    // 'pay_person',
    // 'payment',

    'reservation_status',
    'approve_send_at',
    'category',
  ];

  /*
|--------------------------------------------------------------------------
| PreReservationとの一対多
|--------------------------------------------------------------------------|
*/
  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }

  /*
|--------------------------------------------------------------------------
| breakdownsとの一対多
|--------------------------------------------------------------------------|
*/
  public function pre_breakdowns()
  {
    return $this->hasMany(PreBreakdown::class);
  }

  // prebreakdowns 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->pre_breakdowns()->get() as $child) {
        $child->delete();
      }
    });
  }
}
