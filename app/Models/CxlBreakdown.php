<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CxlBreakdown extends Model
{
  protected $fillable = [
    'unit_item',
    'unit_count',
    'unit_cost',
    'unit_subtotal',
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
}
