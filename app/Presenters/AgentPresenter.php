<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class AgentPresenter extends Presenter
{
  public function getName()
  {
    return $this->person_firstname . $this->person_lastname;
  }
}
