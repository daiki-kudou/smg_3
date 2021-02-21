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
}
