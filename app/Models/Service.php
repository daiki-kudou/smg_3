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

  public function searchs($freeword, $id, $item)
  {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('item', 'LIKE', "%$freeword%")->paginate(10);
    } elseif (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate(10);
    } elseif (isset($item)) {
      return $this->where('item', 'LIKE', "%$item%")->paginate(10);
    } else {
      return $this->query()->paginate(10);
    }
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
}
