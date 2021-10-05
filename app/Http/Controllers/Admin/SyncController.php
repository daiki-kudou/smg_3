<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB; //トランザクション用
use SSH;


class SyncController extends Controller
{

  // ここからsyncさせる！！！！！！！！！！！！！！！！！！！！！！１
  public function sync()
  {
    $test = SSH::run([
      'ls',
    ]);
    dump($test);
    return $test;
  }
}
