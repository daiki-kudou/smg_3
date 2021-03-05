<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

  public function searchs($freeword, $id, $item, $createdat, $page_counter)
  {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('item', 'LIKE', "%$freeword%")
        ->orWhere('price', 'LIKE', "%$freeword%")
        ->orWhere('created_at', 'LIKE', "%$freeword%")
        ->orWhere('remark', 'LIKE', "%$freeword%")->paginate($page_counter);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate($page_counter);
    } else if (isset($item)) {
      return $this->where('item', 'LIKE', "%$item%")->paginate($page_counter);
    } else if (isset($createdat)) {
      return $this->where('created_at', 'LIKE', "%$createdat%")->paginate($page_counter);
    } else {
      return $this->query()->paginate($page_counter);
    }
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
}
