<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


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

    'payment_limit',
    'bill_company',
    'bill_person',
    'bill_created_at',
    'bill_remark',

    'paid',
    'pay_day',
    'pay_person',
    'payment',

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


  public function ReserveStoreBreakdown($request)
  {
    DB::transaction(function () use ($request) {
      $countVenue = $this->RequestBreakdowns($request, 'venue_breakdown_item');
      if ($countVenue != "") {
        for ($i = 0; $i < $countVenue; $i++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'venue_breakdown_item' . $i},
            'unit_cost' => $request->{'venue_breakdown_cost' . $i},
            'unit_count' => $request->{'venue_breakdown_count' . $i},
            'unit_subtotal' => $request->{'venue_breakdown_subtotal' . $i},
            'unit_type' => 1,
          ]);
        }
      }
      // 会場割引
      if ($request->venue_breakdown_discount_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->venue_breakdown_discount_item,
          'unit_cost' => $request->venue_breakdown_discount_cost,
          'unit_count' => $request->venue_breakdown_discount_count,
          'unit_subtotal' => $request->venue_breakdown_discount_subtotal,
          'unit_type' => 1,
        ]);
      }
      $countEqu = $this->RequestBreakdowns($request, 'equipment_breakdown_item');
      if ($countEqu != "") {
        for ($equ = 0; $equ < $countEqu; $equ++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'equipment_breakdown_item' . $equ},
            'unit_cost' => $request->{'equipment_breakdown_cost' . $equ},
            'unit_count' => $request->{'equipment_breakdown_count' . $equ},
            'unit_subtotal' => $request->{'equipment_breakdown_subtotal' . $equ},
            'unit_type' => 2,
          ]);
        }
      }
      $countSer = $this->RequestBreakdowns($request, 'service_breakdown_item');
      if ($countSer != "") {
        for ($ser = 0; $ser < $countSer; $ser++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'service_breakdown_item' . $ser},
            'unit_cost' => $request->{'service_breakdown_cost' . $ser},
            'unit_count' => $request->{'service_breakdown_count' . $ser},
            'unit_subtotal' => $request->{'service_breakdown_subtotal' . $ser},
            'unit_type' => 3,
          ]);
        }
      }
      // 備品割引
      if ($request->equipment_breakdown_discount_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->equipment_breakdown_discount_item,
          'unit_cost' => $request->equipment_breakdown_discount_cost,
          'unit_count' => $request->equipment_breakdown_discount_count,
          'unit_subtotal' => $request->equipment_breakdown_discount_subtotal,
          'unit_type' => 3,
        ]);
      }
      if ($request->luggage_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->luggage_item,
          'unit_cost' => $request->luggage_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->luggage_subtotal,
          'unit_type' => 3,
        ]);
      }
      if ($request->layout_prepare_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_prepare_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_clean_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_breakdown_discount_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->layout_breakdown_discount_item,
          'unit_cost' => $request->layout_breakdown_discount_cost,
          'unit_count' => $request->layout_breakdown_discount_count,
          'unit_subtotal' => $request->layout_breakdown_discount_subtotal,
          'unit_type' => 4,
        ]);
      }
      $countOth = $this->RequestBreakdowns($request, 'others_breakdown_item');
      if ($countOth != "") {
        for ($oth = 0; $oth < $countOth; $oth++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'others_breakdown_item' . $oth},
            'unit_cost' => $request->{'others_breakdown_cost' . $oth},
            'unit_count' => $request->{'others_breakdown_count' . $oth},
            'unit_subtotal' => $request->{'others_breakdown_subtotal' . $oth},
            'unit_type' => 5,
          ]);
        }
      }
    });
  }

  public function LayoutBreakdowns($request) //追加請求書の編集の際のみ利用。　レイアウトの追加を複数可能
  {
    DB::transaction(function () use ($request) {
      $countVenue = $this->RequestBreakdowns($request, 'layout_breakdown_item');
      if ($countVenue != "") {
        for ($i = 0; $i < $countVenue; $i++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'layout_breakdown_item' . $i},
            'unit_cost' => $request->{'layout_breakdown_cost' . $i},
            'unit_count' => $request->{'layout_breakdown_count' . $i},
            'unit_subtotal' => $request->{'layout_breakdown_subtotal' . $i},
            'unit_type' => 1,
          ]);
        }
      }
    });
  }

  public function ReserveFromAgentBreakdown($request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";

    DB::transaction(function () use ($request) {
      $countVenue = $this->RequestBreakdowns($request, 'venue_breakdown_item');
      if ($countVenue != "") {
        for ($i = 0; $i < $countVenue; $i++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'venue_breakdown_item' . $i},
            'unit_cost' => 0,
            'unit_count' => $request->{'venue_breakdown_count' . $i},
            'unit_subtotal' => 0,
            'unit_type' => 1,
          ]);
        }
      }

      $countEqu = $this->RequestBreakdowns($request, 'equipment_breakdown');
      if ($countEqu != "") {
        for ($equ = 0; $equ < $countEqu; $equ++) {
          if (!empty($request->{'equipment_breakdown_item' . $equ})) {
            $this->breakdowns()->create([
              'unit_item' => $request->{'equipment_breakdown_item' . $equ},
              'unit_cost' => 0,
              'unit_count' => $request->{'equipment_breakdown_count' . $equ},
              'unit_subtotal' => 0,
              'unit_type' => 2,
            ]);
          }
        }
      }

      $countSer = $this->RequestBreakdowns($request, 'services_breakdown');
      if ($countSer != "") {
        for ($ser = 0; $ser < $countSer; $ser++) {
          if (!empty($request->{'service_breakdown_item' . $ser})) {
            $this->breakdowns()->create([
              'unit_item' => $request->{'service_breakdown_item' . $ser},
              'unit_cost' => 0,
              'unit_count' => $request->{'service_breakdown_count' . $ser},
              'unit_subtotal' => 0,
              'unit_type' => 3,
            ]);
          }
        }
      }
      if ($request->luggage_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->luggage_item,
          'unit_cost' => 0,
          'unit_count' => 1,
          'unit_subtotal' => 0,
          'unit_type' => 3,
        ]);
      }
      if ($request->layout_prepare_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_prepare_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_item) {
        $this->breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_clean_subtotal,
          'unit_type' => 4,
        ]);
      }
      $countOth = $this->RequestBreakdowns($request, 'others_breakdown_item');
      if ($countOth != "") {
        for ($oth = 0; $oth < $countOth; $oth++) {
          $this->breakdowns()->create([
            'unit_item' => $request->{'others_breakdown_item' . $oth},
            'unit_cost' => 0,
            'unit_count' => $request->{'others_breakdown_count' . $oth},
            'unit_subtotal' => 0,
            'unit_type' => 5,
          ]);
        }
      }
    });
  }

  public function RequestBreakdowns($request, $targetItem)
  {
    $array_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/' . $targetItem . '/', $key)) {
        $array_details[] = $value;
      }
    }
    if (!empty($array_details)) {
      return count($array_details);
    } else {
      return "";
    }
  }

  public function UpdateBill($request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";
    DB::transaction(function () use ($request) {
      $this->update([
        'venue_price' => $request->venue_price,
        'equipment_price' => $request->equipment_price ? $request->equipment_price : 0, //備品・サービス・荷物
        'layout_price' => $request->layout_price ? $request->layout_price : 0,
        'others_price' => $request->others_price ? $request->others_price : 0,
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,
        'payment_limit' => $request->payment_limit,
        'bill_company' => $request->bill_company,
        'bill_person' => $request->bill_person,
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $request->bill_remark,
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => $request->payment,
      ]);
      $this->breakdowns()->delete();
    });
  }
}
