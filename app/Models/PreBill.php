<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; //トランザクション用


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

  public function PreBillStore($pre_reservation_id, $data, $reservation_status = 0, $category = 0)
  {
    $result = $this->create([
      'pre_reservation_id' => $pre_reservation_id,
      'venue_price' => !empty($data['venue_price']) ? $data['venue_price'] : 0,
      'equipment_price' => !empty($data['equipment_price']) ? $data['equipment_price'] : 0,
      'layout_price' => !empty($data['layout_price']) ? $data['layout_price'] : 0,
      'others_price' => !empty($data['others_price']) ? $data['others_price'] : 0,
      'master_subtotal' => $data['master_subtotal'],
      'master_tax' => $data['master_tax'],
      'master_total' => $data['master_total'],
      'reservation_status' => $reservation_status,
      'approve_send_at' => !empty($data['approve_send_at']) ? $data['approve_send_at'] : NULL,
      'category' => $category,
    ]);
    return $result;
  }

  // public function PreBillCreate($request, $pre_reservation)
  // {
  //   DB::transaction(function () use ($request, $pre_reservation) { //トランザクションさせる
  //     $pre_bill = $this->create([
  //       'pre_reservation_id' => $pre_reservation->id,
  //       'venue_price' => !empty($request->venue_price) ? $request->venue_price : 0,
  //       'equipment_price' => !empty($request->equipment_price) ? $request->equipment_price : 0, //備品・サービス・荷物
  //       'layout_price' => !empty($request->layout_price) ? $request->layout_price : 0,
  //       'others_price' => !empty($request->others_price) ? $request->others_price : 0,
  //       // 該当billの合計額関連
  //       'master_subtotal' => $request->master_subtotal,
  //       'master_tax' => $request->master_tax,
  //       'master_total' => $request->master_total,
  //       'reservation_status' => 0,
  //       'category' => 0,
  //     ]);
  //   });
  // }




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
