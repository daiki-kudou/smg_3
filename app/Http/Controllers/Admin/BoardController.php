<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;

class BoardController extends Controller
{
  public function show($reservation_id)
  {
    $reservation = Reservation::with(['user', 'bills.breakdowns', 'agent', 'enduser'])->find($reservation_id);

    return view('admin.board.show', compact('reservation'));
  }
}
