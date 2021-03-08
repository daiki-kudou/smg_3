<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Bill;

class PreBreakdown extends Model
{
  protected $fillable = [
    'pre_bill_id',
    'unit_item',
    'unit_cost',
    'unit_count',
    'unit_subtotal',
    'unit_type'
  ];
  /*
|--------------------------------------------------------------------------
| PreBillsとの一対多
|--------------------------------------------------------------------------|
*/
  public function pre_bills()
  {
    return $this->belongsTo(PreBill::class);
  }

  public function PreBreakdownCreate($request, $pre_reservation)
  {
    DB::transaction(function () use ($request, $pre_reservation) {
      // billモデルにあるLayoutBreakdownsを使う
      $bill = new Bill;
      $countVenue = $bill->RequestBreakdowns($request, 'venue_breakdown_item');
      if ($countVenue != "") {
        for ($i = 0; $i < $countVenue; $i++) {
          $this->create([
            'pre_bill_id' => $pre_reservation->pre_bill->id,
            'unit_item' => $request->{'venue_breakdown_item' . $i},
            'unit_cost' => $request->{'venue_breakdown_cost' . $i},
            'unit_count' => $request->{'venue_breakdown_count' . $i},
            'unit_subtotal' => $request->{'venue_breakdown_subtotal' . $i},
            'unit_type' => 1,
          ]);
        }
      }
      if ($request->venue_breakdown_discount_item) {
        $this->create([
          'pre_bill_id' => $pre_reservation->pre_bill->id,
          'unit_item' => $request->venue_breakdown_discount_item,
          'unit_cost' => $request->venue_breakdown_discount_cost,
          'unit_count' => $request->venue_breakdown_discount_count,
          'unit_subtotal' => $request->venue_breakdown_discount_subtotal,
          'unit_type' => 1,
        ]);
      }

      $countEqu = $bill->RequestBreakdowns($request, 'equipment_breakdown_item');
      if ($countEqu != "") {
        for ($equ = 0; $equ < $countEqu; $equ++) {
          $this->create([
            'pre_bill_id' => $pre_reservation->pre_bill->id,
            'unit_item' => $request->{'equipment_breakdown_item' . $equ},
            'unit_cost' => $request->{'equipment_breakdown_cost' . $equ},
            'unit_count' => $request->{'equipment_breakdown_count' . $equ},
            'unit_subtotal' => $request->{'equipment_breakdown_subtotal' . $equ},
            'unit_type' => 2,
          ]);
        }
      }

      $countSer = $bill->RequestBreakdowns($request, 'service_breakdown_item');
      if ($countSer != "") {
        for ($ser = 0; $ser < $countSer; $ser++) {
          $this->create([
            'pre_bill_id' => $pre_reservation->pre_bill->id,
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
        $this->create([
          'pre_bill_id' => $pre_reservation->pre_bill->id,
          'unit_item' => $request->equipment_breakdown_discount_item,
          'unit_cost' => $request->equipment_breakdown_discount_cost,
          'unit_count' => $request->equipment_breakdown_discount_count,
          'unit_subtotal' => $request->equipment_breakdown_discount_subtotal,
          'unit_type' => 3,
        ]);
      }
      if ($request->luggage_item) {
        $this->create([
          'pre_bill_id' => $pre_reservation->pre_bill->id,
          'unit_item' => $request->luggage_item,
          'unit_cost' => $request->luggage_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->luggage_subtotal,
          'unit_type' => 3,
        ]);
      }
      // レイアウト
      if ($request->layout_prepare_item) {
        $this->create([
          'pre_bill_id' => $pre_reservation->pre_bill->id,
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_prepare_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_item) {
        $this->create([
          'pre_bill_id' => $pre_reservation->pre_bill->id,
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_clean_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_breakdown_discount_item) {
        $this->create([
          'pre_bill_id' => $pre_reservation->pre_bill->id,
          'unit_item' => $request->layout_breakdown_discount_item,
          'unit_cost' => $request->layout_breakdown_discount_cost,
          'unit_count' => $request->layout_breakdown_discount_count,
          'unit_subtotal' => $request->layout_breakdown_discount_subtotal,
          'unit_type' => 4,
        ]);
      }
      $countOth = $bill->RequestBreakdowns($request, 'others_breakdown_item');
      if ($countOth != "") {
        for ($oth = 0; $oth < $countOth; $oth++) {
          $this->create([
            'pre_bill_id' => $pre_reservation->pre_bill->id,
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
}
