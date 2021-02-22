<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class MultipleReservePresenter extends Presenter
{
  public function test()
  {
    return 'これはtestです' . $this->id;
  }

  public function getPreReservations($venue_id)
  {
    return $this->pre_reservations()->where('venue_id', $venue_id)->get();
  }

  public function sumVenues($venue_id)
  {
    $venue_prices = 0;
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

    foreach ($pre_reservations as $key => $value) {
      $venue_prices += $value->pre_bill->venue_price;
    }
    return $venue_prices;
  }

  public function sumEquips($venue_id)
  {
    $equipment_price = 0;
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

    foreach ($pre_reservations as $key => $value) {
      $equipment_price += $value->pre_bill->equipment_price;
    }
    return $equipment_price;
  }

  public function sumLayouts($venue_id)
  {
    $layout_price = 0;
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

    foreach ($pre_reservations as $key => $value) {
      $layout_price += $value->pre_bill->layout_price;
    }
    return $layout_price;
  }

  public function sumMasterSubs($venue_id)
  {
    $masters = 0;
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

    foreach ($pre_reservations as $key => $value) {
      $masters += $value->pre_bill->master_subtotal;
    }
    return $masters;
  }

  public function sumMasterTax($venue_id)
  {
    $tax = 0;
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

    foreach ($pre_reservations as $key => $value) {
      $tax += $value->pre_bill->master_tax;
    }
    return $tax;
  }

  public function sumMasterTotal($venue_id)
  {
    $total = 0;
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

    foreach ($pre_reservations as $key => $value) {
      $total += $value->pre_bill->master_total;
    }
    return $total;
  }
}
