<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class VenuePresenter extends Presenter
{

  public function getEquipments()
  {
    $equipments = $this->equipments()->get();
    return $equipments;
  }

  public function getServices()
  {
    $services = $this->services()->get();
    return $services;
  }

  public function getLayouts()
  {
    $layout_prepare = $this->layout_prepare;
    $layout_clean = $this->layout_clean;
    $sum = (int)$layout_prepare + (int)$layout_clean;
    if ($sum) {
      return [$layout_prepare, $layout_clean, $sum];
    } else {
      return 0;
    }
  }

  public function getLuggage()
  {
    return $this->luggage_flag;
  }
}
