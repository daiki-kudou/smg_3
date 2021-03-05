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

  public function searchs($freeword, $id, $item, $page_counter = 10)
  {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('item', 'LIKE', "%$freeword%")->paginate($page_counter);
    } elseif (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate($page_counter);
    } elseif (isset($item)) {
      return $this->where('item', 'LIKE', "%$item%")->paginate($page_counter);
    } else {
      return $this->query()->paginate($page_counter);
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
