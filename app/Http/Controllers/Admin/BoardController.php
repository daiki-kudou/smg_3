<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;

class BoardController extends Controller
{
  public function show(Request $request)
  {
    $reservation = Reservation::with(['user', 'bills.breakdowns', 'agent'])->find($request->reservation_id);
    $bill = $reservation->bills->find($request->bill_id);

    return view('admin.board.show', compact('reservation'));
  }
}
