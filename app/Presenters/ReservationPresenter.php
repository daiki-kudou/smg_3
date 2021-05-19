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
    $subtotal = $this->bills->where('reservation_status', '<=', 3)->pluck('master_total')->sum();
    $cxl = $this->cxls->pluck('master_total')->sum();
    return $subtotal + $cxl;
  }

  public function cxlSubtotal()
  {
    return $this->cxls->pluck('master_total')->sum();
  }

  public function cxlCost()
  {
    $subtotal = $this->cxlSubtotal();
    if ($this->venue->alliance_flag == 0) {
      return 0;
    } else {
      $percent = ($this->cost) * 0.01;
      $layout = [];
      foreach ($this->cxls as $key => $value) {
        $layout[] = $value->cxl_breakdowns->where('unit_percent_type', 3)->first()->unit_subtotal ?? 0;
      }
      $layout = array_sum($layout);
      return ($subtotal - ($layout * 1.1)) * $percent;
    }
  }

  public function cxlProfit()
  {
    $subtotal = $this->cxlSubtotal();
    $cost = $this->cxlCost();
    return $subtotal - $cost;
  }

  public function totalPaid()
  {
    return $this->bills->pluck('payment')->sum();
  }

  public function balance($sales)
  {
    return $sales - $this->totalPaid();
  }
}
