<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
