<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Cxl extends Model
{
  protected $fillable = [
    'reservation_id',
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

  public function reservation()
  {
    return $this->belongsTo('App\Models\Reservation');
  }


  public function cxl_breakdowns()
  {
    return $this->hasMany('App\Models\CxlBreakdown');
  }

  public function calcCxlAmount()
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    var_dump($info[0]);

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


  public function storeCxl($data, $invoice, $bill_id, $reservation_id)
  {
    $cxlBill = DB::transaction(function () use ($data, $invoice, $bill_id, $reservation_id) {
      $cxlBill = $this->create([
        'reservation_id' => $reservation_id,
        'bill_id' => $bill_id,
        'master_subtotal' => $invoice['master_subtotal'],
        'master_tax' => $invoice['master_tax'],
        'master_total' => $invoice['master_total'],
        'payment_limit' => $invoice['payment_limit'],
        'bill_company' => $invoice['bill_company'],
        'bill_person' => $invoice['bill_person'],
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $invoice['bill_remark'],
        'paid' => $invoice["paid"],
        'pay_day' => $invoice['pay_day'],
        'pay_person' => $invoice['pay_person'],
        'payment' => $invoice['payment'],
        'cxl_status' => 0,
        // 　0:キャンセル申請中　1:キャンセル承認待ち　2:キャンセル
        'double_check_status' => 0,
        // ダブルチェックのフラグ 0:未　1:一人済　2:二人済
        'category' => 0,
      ]);
      return $cxlBill;
    });
    return $cxlBill;
  }

  public function storeCxlBreakdown($data, $invoice)
  {
    DB::transaction(function () use ($data, $invoice) {
      foreach ($invoice['cxl_unit_subtotal'] as $key => $value) {
        $this->cxl_breakdowns()->create([
          'unit_item' => $invoice['cxl_unit_item'][$key],
          'unit_count' => $invoice['cxl_unit_count'][$key],
          'unit_cost' => $invoice['cxl_unit_cost'][$key],
          'unit_subtotal' => $invoice['cxl_unit_subtotal'][$key],
          'unit_type' => 1 //1が計算結果　2が計算対象
        ]);
      }
      foreach ($invoice['cxl_target_percent'] as $key => $value) {
        $this->cxl_breakdowns()->create([
          'unit_item' => $invoice['cxl_target_item'][$key],
          'unit_count' => $invoice['cxl_target_percent'][$key],
          'unit_cost' => $invoice['cxl_target_cost'][$key],
          'unit_subtotal' => 0, //計算対象は合計金額がない
          'unit_type' => 2 //1が計算結果　2が計算対象
        ]);
      }
    });
  }
  public function doubleCheck($doubleCheckStatus, $cxlId, $doubleCheckName, $doubleCheckName2 = "")
  {
    if ($doubleCheckStatus == 0) {
      $this->update([
        'double_check1_name' => $doubleCheckName,
        'double_check_status' => 1
      ]);
    } elseif ($doubleCheckStatus == 1) {
      $this->update([
        'double_check2_name' => $doubleCheckName2,
        'double_check_status' => 2
      ]);
    }
  }
}
