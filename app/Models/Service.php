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
}
