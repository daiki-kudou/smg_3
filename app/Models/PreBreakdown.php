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

  public function PreBreakdownStore($pre_bill_id, $data)
  {
    if (!empty($data['venue_breakdown_item'])) {
      $this->storeEach(
        $pre_bill_id,
        $data['venue_breakdown_item'],
        $data['venue_breakdown_cost'],
        $data['venue_breakdown_count'],
        $data['venue_breakdown_subtotal'],
        1,
      );
    }

    if (!empty($data['equipment_breakdown_item'])) {
      $this->storeEach(
        $pre_bill_id,
        $data['equipment_breakdown_item'],
        $data['equipment_breakdown_cost'],
        $data['equipment_breakdown_count'],
        $data['equipment_breakdown_subtotal'],
        2,
      );
    }

    if (!empty($data['service_breakdown_item'])) {
      $this->storeEach(
        $pre_bill_id,
        $data['service_breakdown_item'],
        $data['service_breakdown_cost'],
        $data['service_breakdown_count'],
        $data['service_breakdown_subtotal'],
        3,
      );
    }

    if (!empty($data['layout_breakdown_item'])) {
      $this->storeEach(
        $pre_bill_id,
        $data['layout_breakdown_item'],
        $data['layout_breakdown_cost'],
        $data['layout_breakdown_count'],
        $data['layout_breakdown_subtotal'],
        4,
      );
    }

    if (!empty($data['others_breakdown_item'])) {
      $this->storeEach(
        $pre_bill_id,
        $data['others_breakdown_item'],
        $data['others_breakdown_cost'],
        $data['others_breakdown_count'],
        $data['others_breakdown_subtotal'],
        5,
      );
    }
  }

  protected function storeEach($pre_bill_id, $item, $cost, $count, $sub_total, $unit_type)
  {
    foreach ($item as $key => $value) {
      $this->create([
        'pre_bill_id' => $pre_bill_id,
        'unit_item' => $item[$key],
        'unit_cost' => $cost[$key],
        'unit_count' => $count[$key],
        'unit_subtotal' => $sub_total[$key],
        'unit_type' => $unit_type,
      ]);
    }
  }
}
