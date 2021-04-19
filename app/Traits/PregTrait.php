<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Reservation;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB; //トランザクション用


trait PregTrait
{
  public function preg($array, $inputNames)
  {
    $cnt = 0;
    foreach ($array as $key => $value) {
      if (preg_match("/$inputNames/", $key)) {
        !empty($value) ? $cnt++ : "";
      }
    }
    return $cnt;
  }
}
