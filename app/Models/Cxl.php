<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Cxl extends Model
{

  protected $fillable = [
    'bill_id',
    'master_subtotal',
    'master_tax',
    'master_total',
    'payment_limit',
    'bill_company',
    'bill_person',
    'bill_created_at',
    'bill_remark',
    'paid',
    'pay_day',
    'pay_person',
    'payment',
    'cxl_status',
    'double_check_status',
    'double_check1_name',
    'double_check2_name',
    'approve_send_at',
    'category',
  ];

  public function bill()
  {
    return $this->belongsTo(Bill::class);
  }

  public function calcCxlAmount()
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');

    $venue_result = !empty($data['cxl_venue_PC']) ? $this->eachCalc($info[0], $data['cxl_venue_PC']) : 0;
    $equ_result = !empty($data['cxl_equipment_PC']) ? $this->eachCalc($info[1], $data['cxl_equipment_PC']) : 0;
    $lay_result = !empty($data['cxl_layout_PC']) ? $this->eachCalc($info[2], $data['cxl_layout_PC']) : 0;
    $oth_result = !empty($data['cxl_other_PC']) ? $this->eachCalc($info[3], $data['cxl_other_PC']) : 0;
    $subtotal = $venue_result + $equ_result + $lay_result + $oth_result;
    return [$venue_result, $equ_result, $lay_result, $oth_result, $subtotal];
  }

  public function eachCalc($target, $target2)
  {
    if (!empty($target)) {
      return $target * ((int)$target2 / 100);
    } else {
      return 0;
    }
  }


  public function storeCxl($data, $invoice)
  {
    // $cxlBill = DB::transaction(function () use ($data, $invoice) {
    //   $cxlBill = $this->create([
    //     'bill_id' => $request->bill_id,
    //     'master_subtotal' => $request->master_subtotal,
    //     'master_tax' => $request->master_tax,
    //     'master_total' => $request->master_total,
    //     'payment_limit' => $request->payment_limit,
    //     'bill_company' => $request->bill_company,
    //     'bill_person' => $request->bill_person,
    //     'bill_created_at' => Carbon::now(),
    //     'bill_remark' => $request->bill_remark,
    //     'paid' => $request->paid,
    //     'pay_day' => $request->pay_day,
    //     'pay_person' => $request->pay_person,
    //     'payment' => $request->payment,
    //     'cxl_status' => 0,
    //     // 　0:キャンセル申請中　1:キャンセル承認待ち　2:キャンセル
    //     'double_check_status' => 0,
    //     // ダブルチェックのフラグ 0:未　1:一人済　2:二人済
    //     'category' => 0,
    //   ]);
    //   return $cxlBill;
    // });
    // return $cxlBill;
  }

  public function storeCxlBreakdown($request)
  {
    DB::transaction(function () use ($request) {
      $cxlBill = $this->create([
        'bill_id' => $request->bill_id,
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,
        'payment_limit' => $request->payment_limit,
        'bill_company' => $request->bill_company,
        'bill_person' => $request->bill_person,
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $request->bill_remark,
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => $request->payment,
        'cxl_status' => 0,
        // 　0:キャンセル申請中　1:キャンセル承認待ち　2:キャンセル
        'double_check_status' => 0,
        // ダブルチェックのフラグ 0:未　1:一人済　2:二人済
        'category' => 0,
      ]);
      return $cxlBill;
    });
  }
}
