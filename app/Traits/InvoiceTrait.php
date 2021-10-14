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
    $tempNum = (int)date('ymdHis');

    $cxls = Cxl::get();
    $bills = Bill::get();

    foreach ($cxls->sortBy('invoice_number') as $key => $value) {
      if ($value->invoice_number === $tempNum) {
        $tempNum++;
      }
    }

    foreach ($bills->sortBy('invoice_number') as $key => $value) {
      if ($value->invoice_number === $tempNum) {
        $tempNum++;
      }
    }

    return $tempNum;
  }
}
