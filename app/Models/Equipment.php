<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Equipment extends Model
{
  protected $fillable = ['item', 'price', 'stock', 'remark'];

  protected $table = 'equipments';
  // 明示的に指定。以下参照
  // https://qiita.com/janet_parker/items/6f6c8561f201fdcbcdb0

  public function venues()
  {
    return $this->belongsToMany('App\Models\Venue');
  }


  public static function getArrays($request)
  {
    $s_equipment = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
    }
    return $s_equipment;
  }

  public static function sumArrays($request)
  {
    $arrays = self::getArrays($request);
    $counter = 0;
    foreach ($arrays as $key => $value) {
      $counter += $value;
    }
    return $counter;
  }

  public static function getBreakdowns($request)
  {
    $equipment_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdown_item/', $key)) {
        $equipment_details[] = $value;
      }
    }
    if (!empty($equipment_details)) {
      return count($equipment_details);
    } else {
      return "";
    }
  }

  public static function getSessionArrays($array)
  {
    $s_equipment = [];
    foreach ($array->all() as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
    }
    return $s_equipment;
  }
}
