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

  public function billCount()
  {
    return $this->bills->count();
  }

  public function cxlCount()
  {
    return $this->cxls->count();
  }

  public function totalAmountWithCxl()
  {
    // return $this->cxls->count();
    $main = $this->bills->where('reservation_status', '<=', 3)->pluck('master_total')->sum();
    $cxl = $this->cxls->pluck('master_total')->sum();
    return $main + $cxl;
  }
}
