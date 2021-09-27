<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CxlBreakdown extends Model
{
  protected $fillable = [
    'cxl_id',
    'unit_item',
    'unit_count',
    'unit_cost',
    'unit_subtotal',
    'unit_type',
    'unit_percent',
    'unit_percent_type'
  ];

  protected $casts = [
    'unit_count' => 'integer',
    'unit_cost' => 'integer',
    'unit_subtotal' => 'integer',
  ];


  public function cxl()
  {
    return $this->belongsTo('App\Models\Cxl');
  }

  public function BreakdownStore($cxl_id, $data)
  {
    foreach ($data['cxl_target_item'] as $key => $value) {
      $this->create([
        'cxl_id' => $cxl_id,
        'unit_item' => $data['cxl_unit_item'][$key],
        'unit_count' => $data['cxl_unit_count'][$key],
        'unit_cost' => $data['cxl_unit_cost'][$key],
        'unit_subtotal' => $data['cxl_unit_subtotal'][$key],
        'unit_type' => 1, //1が計算結果　2が計算対象
        'unit_percent' => $data['cxl_target_percent'][$key],
        'unit_percent_type' => $data['cxl_target_type'][$key],
      ]);
    }
  }
}
