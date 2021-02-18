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
    return [$layout_prepare, $layout_clean];
  }
  public function getLuggage()
  {
    return $this->luggage_flag;
  }
}
