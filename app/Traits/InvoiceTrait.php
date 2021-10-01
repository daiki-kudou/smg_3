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
    $tempNum = date('ym');

    $cxls = Cxl::get()->count();
    $bills = Bill::get()->count();
    $num = (int)$cxls + (int)$bills;
    return (string)$tempNum . sprintf('%04d', $num);
  }
}
