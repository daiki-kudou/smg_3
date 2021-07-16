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
    $invoice_number = date('Y') . date('m') . mt_rand(0, 9) . sprintf('%03d', ($search_bill_count + 1));
    return $invoice_number;
  }
}
