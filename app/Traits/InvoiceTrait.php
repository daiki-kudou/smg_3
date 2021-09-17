<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bill;

trait InvoiceTrait
{
  public function generateInvoiceNum()
  {
    $search_bill_count = Bill::where("created_at", "LIKE", "%" . (date("Y-m")) . "%")->count();
    $invoice_number = date('ymdHi');
    $checkUniqueArray = Bill::pluck('invoice_number')->toArray();
    foreach ($checkUniqueArray as $key => $value) {
      if ($invoice_number === $value) {
        $invoice_number = date('ymdHis');
      }
    }
    return $invoice_number;
  }
}
