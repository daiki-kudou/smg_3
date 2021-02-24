<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
  public function create(Request $request)
  {
    var_dump($request->all());
  }
}
