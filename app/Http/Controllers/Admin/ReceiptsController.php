<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Bill;

class ReceiptsController extends Controller
{
  public function show($bill_id)
  {
    $bill = Bill::find($bill_id);
    return view('admin.receipts.show');
  }
}
