<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;

use App\Traits\InvoiceTrait;
use App\Service\SendSMGEmail;



class Cxl extends Model
{

  use InvoiceTrait;

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
    'invoice_number',
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
  //  管理者予約保存
  public function CxlStore($data)
  {
    $result = $this->create([
      'bill_id' => 0, // 個別キャンセルがなくなったため。0で固定
      'master_subtotal' => $data['master_subtotal'],
      'master_tax' => $data['master_tax'],
      'master_total' => $data['master_total'],
      'payment_limit' => $data['payment_limit'],
      'bill_company' => $data['bill_company'],
      'bill_person' => $data['bill_person'],
      'bill_created_at' => $data['bill_created_at'],
      'bill_remark' => $data['bill_remark'],
      'paid' => $data['paid'],
      'pay_day' => $data['pay_day'],
      'pay_person' => $data['pay_person'],
      'payment' => $data['payment'],
      'cxl_status' =>   0,  //0:キャンセル申請中　1:キャンセル承認待ち　2:キャンセル
      'double_check_status' => 0, // ダブルチェックのフラグ 0:未　1:一人済　2:二人済
      'double_check1_name' => "",
      'double_check2_name' => "",
      'approve_send_at' => NULL,
      'category' => 0,
      'reservation_id' => $data['reservation_id'],
      'invoice_number' => $this->generateInvoiceNum(),
    ]);
    return $result;
  }

  // public function storeCxl($data, $invoice, $bill_id, $reservation_id)
  // {
  //   $cxlBill = DB::transaction(function () use ($data, $invoice, $bill_id, $reservation_id) {
  //     $cxlBill = $this->create([
  //       'reservation_id' => $reservation_id,
  //       'bill_id' => $bill_id,
  //       'master_subtotal' => $invoice['master_subtotal'],
  //       'master_tax' => $invoice['master_tax'],
  //       'master_total' => $invoice['master_total'],
  //       'payment_limit' => $invoice['payment_limit'],
  //       'bill_company' => !empty($invoice['bill_company']) ? $invoice['bill_company'] : "",
  //       'bill_person' => $invoice['bill_person'],
  //       'bill_created_at' => Carbon::now(),
  //       'bill_remark' => $invoice['bill_remark'],
  //       'paid' => $invoice["paid"],
  //       'pay_day' => $invoice['pay_day'],
  //       'pay_person' => $invoice['pay_person'],
  //       'payment' => $invoice['payment'],
  //       'cxl_status' => 0,
  //       // 　0:キャンセル申請中　1:キャンセル承認待ち　2:キャンセル
  //       'double_check_status' => 0,
  //       // ダブルチェックのフラグ 0:未　1:一人済　2:二人済
  //       'category' => 0,
  //       'invoice_number' => $this->generateInvoiceNum(),
  //     ]);
  //     return $cxlBill;
  //   });
  //   return $cxlBill;
  // }

  // public function storeCxlBreakdown($data, $invoice)
  // {
  //   DB::transaction(function () use ($data, $invoice) {
  //     foreach ($invoice['cxl_unit_subtotal'] as $key => $value) {
  //       $this->cxl_breakdowns()->create([
  //         'unit_item' => $invoice['cxl_unit_item'][$key],
  //         'unit_count' => $invoice['cxl_unit_count'][$key],
  //         'unit_cost' => $invoice['cxl_unit_cost'][$key],
  //         'unit_subtotal' => $invoice['cxl_unit_subtotal'][$key],
  //         'unit_type' => 1, //1が計算結果　2が計算対象
  //         'unit_percent' => $invoice['cxl_unit_percent'][$key],
  //         'unit_percent_type' => $invoice['cxl_target_type'][$key],
  //       ]);
  //     }
  //     foreach ($invoice['cxl_target_percent'] as $key => $value) {
  //       $this->cxl_breakdowns()->create([
  //         'unit_item' => $invoice['cxl_target_item'][$key],
  //         'unit_count' => $invoice['cxl_target_percent'][$key],
  //         'unit_cost' => $invoice['cxl_target_cost'][$key],
  //         'unit_subtotal' => 0, //計算対象は合計金額がない
  //         'unit_type' => 2, //1が計算結果　2が計算対象
  //         'unit_percent' => 0, //計算結果のため、キャンセル料率の表示は不要
  //         'unit_percent_type' => 0 //計算結果のため、タイプは不要
  //       ]);
  //     }
  //   });
  // }

  public function CxlUpdate($data)
  {
    $this->update([
      'bill_id' => 0, // 個別キャンセルがなくなったため。0で固定
      'master_subtotal' => $data['master_subtotal'],
      'master_tax' => $data['master_tax'],
      'master_total' => $data['master_total'],
      'payment_limit' => $data['payment_limit'],
      'bill_company' => $data['bill_company'],
      'bill_person' => $data['bill_person'],
      'bill_created_at' => $data['bill_created_at'],
      'bill_remark' => $data['bill_remark'],
      'paid' => $data['paid'],
      'pay_day' => $data['pay_day'],
      'pay_person' => $data['pay_person'],
      'payment' => $data['payment'],
      'cxl_status' =>   0,  //0:キャンセル申請中　1:キャンセル承認待ち　2:キャンセル
      'double_check_status' => 0, // ダブルチェックのフラグ 0:未　1:一人済　2:二人済
      'double_check1_name' => "",
      'double_check2_name' => "",
      'approve_send_at' => NULL,
      'category' => 0,
      'reservation_id' => $data['reservation_id'],
      'invoice_number' => $this->generateInvoiceNum(),
    ]);
    return $this;
  }



  // public function updateCxlBreakdowns($data, $invoice)
  // {
  //   DB::transaction(function () use ($data, $invoice) {
  //     foreach ($invoice['cxl_unit_subtotal'] as $key => $value) {
  //       $this->cxl_breakdowns()->create([
  //         'unit_item' => $invoice['cxl_unit_item'][$key],
  //         'unit_count' => $invoice['cxl_unit_count'][$key],
  //         'unit_cost' => $invoice['cxl_unit_cost'][$key],
  //         'unit_subtotal' => $invoice['cxl_unit_subtotal'][$key],
  //         'unit_type' => 1, //1が計算結果　2が計算対象
  //         'unit_percent' => $invoice['cxl_unit_percent'][$key],
  //         'unit_percent_type' => $invoice['cxl_target_type'][$key],
  //       ]);
  //     }
  //     foreach ($invoice['cxl_target_percent'] as $key => $value) {
  //       $this->cxl_breakdowns()->create([
  //         'unit_item' => $invoice['cxl_target_item'][$key],
  //         'unit_count' => $invoice['cxl_target_percent'][$key],
  //         'unit_cost' => $invoice['cxl_target_cost'][$key],
  //         'unit_subtotal' => 0, //計算対象は合計金額がない
  //         'unit_type' => 2, //1が計算結果　2が計算対象
  //         'unit_percent' => 0, //計算結果のため、キャンセル料率の表示は不要
  //         'unit_percent_type' => 0 //計算結果のため、タイプは不要
  //       ]);
  //     }
  //   });
  // }





  public function doubleCheck(
    $doubleCheckStatus,
    $cxlId,
    $doubleCheckName,
    $doubleCheckName2 = ""
  ) {
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

  public function sendCxlEmail($cxl_id)
  {
    $SendSMGEmail = new SendSMGEmail();
    $SendSMGEmail->send("管理者ダブルチェック完了後、キャンセル承認メールをユーザーへ送付", $cxl_id);
  }

  public function updateCxlStatusByEmail($status)
  {
    $result = DB::transaction(function () use ($status) {
      $result = $this->update([
        'cxl_status' => $status,
        'approve_send_at' => Carbon::now(),
      ]);
      return $result;
    });
  }

  public function updateReservationStatusByCxl($status)
  {
    if ($this->bill_id == 0) {
      //cxlのbill_id=0は該当予約の全てのbillのキャンセル
      $target = $this->reservation->bills;
      DB::transaction(function () use ($target, $status) {
        foreach ($target as $key => $value) {
          $value->update([
            'reservation_status' => $status
          ]);
        }
      });
    } else {
      $this->bill->update([
        'reservation_status' => $status
      ]);
    }
  }

  public function CxlEmailTemplate($cxl_id)
  {
    $result = DB::table('cxls')
      ->select(DB::raw(
        "
          users.company as company,
          LPAD(reservations.id,6,0) as reservation_id,
          LPAD(users.id,6,0) as user_id,
          users.email as user_email,
          cxls.invoice_number as invoice_number,
          concat(date_format(reservations.reserve_date, '%Y/%m/%d'),
          case 
          when DAYOFWEEK(reservations.reserve_date) = 1 then '(日)' 
          when DAYOFWEEK(reservations.reserve_date) = 2 then '(月)'
          when DAYOFWEEK(reservations.reserve_date) = 3 then '(火)'
          when DAYOFWEEK(reservations.reserve_date) = 4 then '(水)'
          when DAYOFWEEK(reservations.reserve_date) = 5 then '(木)'
          when DAYOFWEEK(reservations.reserve_date) = 6 then '(金)'
          when DAYOFWEEK(reservations.reserve_date) = 7 then '(土)'
          end
          ) as reserve_date,
          time_format(reservations.enter_time, '%H:%i') as enter_time,
          time_format(reservations.leave_time, '%H:%i') as leave_time,
          concat(name_area, name_bldg, name_venue) as venue_name,
          format(cxls.master_total,0) as master_total,
          venues.smg_url
        "
      ))
      ->leftJoin('reservations', 'reservations.id', '=', 'cxls.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('venues', 'venues.id', '=', 'reservations.venue_id')
      ->whereRaw('cxls.id = ?', [$cxl_id]);

    return $result->first();
  }
}
