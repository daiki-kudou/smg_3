<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class ReservationPresenter extends Presenter
{
  public function cxlGray()
  {
    $target = $this->bills->pluck('reservation_status');
    $result = $target->every(function ($value, $key) {
      return ($value == 6);
    });

    return $result;
  }
}
