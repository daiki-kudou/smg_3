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

    $cxls = Cxl::get();
    $bills = Bill::get();
    $num = $cxls->count() + $bills->count() + 1;
    $newNum = (string)$tempNum . sprintf('%04d', $num);

    foreach ($cxls->sortBy('invoice_number') as $key => $value) {
      if ($value->invoice_number === $newNum) {
        $num++;
      }
    }
    foreach ($bills->sortBy('invoice_number') as $key => $value) {
      if ($value->invoice_number === $newNum) {
        $num++;
      }
    }
    $newNum = (string)$tempNum . sprintf('%04d', $num);

    return $newNum;
  }
}
