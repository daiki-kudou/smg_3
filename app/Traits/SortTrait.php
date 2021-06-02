<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB; //トランザクション用


trait SortTrait
{
  /**
   * 特定のリクエストに沿ってソート
   * 
   * @param object $model
   * @param object $request
   * @return object
   */
  public function customSort($model, $request)
  {
    // 1降順　2昇順
    foreach ($request as $key => $value) {
      if (!empty($value)) {
        if ($value == 1) {
          return $model->sortByDesc($key);
        } else {
          return $model->sortBy($key);
        }
      }
    }
  }
}
