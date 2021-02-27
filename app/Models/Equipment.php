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

  public function searchs($freeword, $id, $item, $createdat)
  {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('item', 'LIKE', "%$freeword%")
        ->orWhere('price', 'LIKE', "%$freeword%")
        ->orWhere('created_at', 'LIKE', "%$freeword%")
        ->orWhere('remark', 'LIKE', "%$freeword%")->paginate(10);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate(10);
    } else if (isset($item)) {
      return $this->where('item', 'LIKE', "%$item%")->paginate(10);
    } else if (isset($createdat)) {
      return $this->where('created_at', 'LIKE', "%$createdat%")->paginate(10);
    } else {
      return $this->query()->paginate(10);
    }
  }
}
