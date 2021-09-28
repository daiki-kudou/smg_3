<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bill;

trait InvoiceTrait
{
  public function generateInvoiceNum()
  {
    //   $invoice_number = date('ymdHi');
    //   $checkUniqueArray = Bill::pluck('invoice_number')->toArray();
    //   foreach ($checkUniqueArray as $key => $value) {
    //     if ((int)$invoice_number !== (int)$value) {
    //       return $invoice_number;
    //       break;
    //     } else {
    //       (int)$invoice_number += 1;
    //       continue;
    //     }
    //   }
    //   return $invoice_number;
    // }
    $today = Carbon::now();
    $tempNum = date('ym');
    $invoiceId = (int)Bill::whereDate('created_at', $today)->get()->count() + 3;
    return (string)$tempNum . sprintf('%04d', $invoiceId);
  }
}
