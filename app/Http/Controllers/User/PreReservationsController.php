<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PreReservation;
use App\Models\PreBill;
use App\Models\PreBreakdown;


class PreReservationsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth']);
  }

  public function index()
  {
    $user_id = auth()->user()->id;
    $pre_reservations = PreReservation::where('user_id', $user_id)->get();
    return view('user.pre_reservations.index', [
      'pre_reservations' => $pre_reservations
    ]);
  }
}
