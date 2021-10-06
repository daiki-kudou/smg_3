<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Sync\Sync;



class SyncController extends Controller
{

  public function sync()
  {
    // jobをここでdispatchする！
    Sync::dispatch();
  }
}
