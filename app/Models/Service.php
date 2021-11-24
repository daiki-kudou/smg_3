<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

  protected $fillable = ['item', 'price', 'remark'];

  // 中間テーブル連携
  public function venues()
  {
    return $this->belongsToMany('App\Models\Venue');
  }

  public static function getArrays($request)
  {
    $s_services = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/services_breakdown/', $key)) {
        $s_services[] = $value;
      }
    }
    return $s_services;
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
    $service_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/services_breakdown_item/', $key)) {
        $service_details[] = $value;
      }
    }
    if (!empty($service_details)) {
      return count($service_details);
    } else {
      return "";
    }
  }

  public static function getSessionArrays($array)
  {
    $s_services = [];
    foreach ($array->all() as $key => $value) {
      if (preg_match('/services_breakdown/', $key)) {
        $s_services[] = $value;
      }
    }
    if (empty($s_services)) {
      $s_services = [[0]];
    }

    return $s_services;
  }
}
