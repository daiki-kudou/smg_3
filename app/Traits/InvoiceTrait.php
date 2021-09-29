<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Cxl;

trait InvoiceTrait
{
  public function generateInvoiceNum()
  {
    $today = Carbon::now();
    $tempNum = date('ymd');
    $cxls = Cxl::whereDate('created_at', $today)->get();
    $bills = Bill::whereDate('created_at', $today)->get();
    $customNum = (int)$cxls->count() + (int)$bills->count() + 1;
    $comp = $tempNum . sprintf('%02d', $customNum);
    foreach ($cxls as $key => $value) {
      if ($value->invoice_number === (int)$comp) {
        $customNum += 1;
      }
    }
    foreach ($bills as $key => $value) {
      if ($value->invoice_number === (int)$comp) {
        $customNum += 1;
      }
    }
    return (string)$tempNum . sprintf('%02d', $customNum);
  }
}
