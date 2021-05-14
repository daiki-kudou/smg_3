<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Cxl;

class ReceiptsController extends Controller
{
  public function show(Request $request)
  {
    if ($request->bill_id) {
      $bill = Bill::with(['reservation.user', 'reservation.agent', 'breakdowns'])->find($request->bill_id);
      $cxl = "";
      return view('admin.receipts.show', compact('bill', 'cxl'));
    } else {
      $bill = "";
      $cxl = Cxl::with('cxl_breakdowns')->find($request->cxl_id);
      return view('admin.receipts.show', compact('cxl', 'bill'));
    }
  }
}
