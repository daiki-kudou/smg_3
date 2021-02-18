<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class MultipleReservePresenter extends Presenter
{
  public function test()
  {
    return 'これはtestです' . $this->id;
  }
}
