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
    $cxls = Cxl::whereDate('created_at', $today)->get()->count();
    $bills = Bill::whereDate('created_at', $today)->get()->count();
    $customNum = $cxls + $bills + 1;
    return (string)$tempNum . sprintf('%02d', $customNum);
  }
}
