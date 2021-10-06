<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Sync\Sync;

use Session;



class SyncController extends Controller
{

  public function sync()
  {
    // jobをここでdispatchする！
    Sync::dispatch();
    session()->flash('flash_message', 'MovableTypeを同期しています。');
    return back();
  }
}
