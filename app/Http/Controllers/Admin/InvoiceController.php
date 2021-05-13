<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;

class InvoiceController extends Controller
{
  public function show(Request $request)
  {
    $reservation = Reservation::with(['user', 'bills.breakdowns', 'agent','cxls'])->find($request->reservation_id);
    $bill = $reservation->bills->find($request->bill_id);
    $cxl=$reservation->cxls->find($request->cxl_id);
    return view('admin.invoice.show', compact('reservation', 'bill','cxl'));
  }
}
