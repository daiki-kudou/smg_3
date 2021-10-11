<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Traits\PregTrait;
use App\Traits\InvoiceTrait;


class Bill extends Model
{
  use PregTrait;
  use InvoiceTrait;
  use SoftDeletes;

  protected $fillable = [
    'reservation_id',
    'venue_price',
    'equipment_price',
    'layout_price',
    'others_price',
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
    'reservation_status',
    'double_check_status',
    'double_check1_name',
    'double_check2_name',
    'approve_send_at',
    'category',
    'admin_judge',
    'end_user_charge',
    'invoice_number',
  ];
  protected $dates = [
    'pay_day',
    'payment_limit',
  ];


  /*
|--------------------------------------------------------------------------
| Reservationとの一対多
|--------------------------------------------------------------------------|
*/
  public function reservation()
  {
    return $this->belongsTo(Reservation::class);
  }
  /*
|--------------------------------------------------------------------------
| breakdownsとの一対多
|--------------------------------------------------------------------------|
*/
  public function breakdowns()
  {
    return $this->hasMany(Breakdown::class);
  }

  // breakdowns 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->breakdowns()->get() as $child) {
        $child->delete();
      }
    });
  }

  /*
|--------------------------------------------------------------------------
| cxlとの１対１
|--------------------------------------------------------------------------|
*/
  public function cxl()
  {
    return $this->hasOne(Cxl::class);
  }

  public function BillStore($reservation_id, $data, $reservation_status = 1, $double_check_status = 0, $category = 1, $admin_judge = 1)
  {
    $result = $this->create([
      'reservation_id' => $reservation_id,
      'venue_price' => !empty($data['venue_price']) ? $data['venue_price'] : 0,
      'equipment_price' => !empty($data['equipment_price']) ? $data['equipment_price'] : 0,
      'layout_price' => !empty($data['layout_price']) ? $data['layout_price'] : 0,
      'others_price' => !empty($data['others_price']) ? $data['others_price'] : 0,
      'master_subtotal' => $data['master_subtotal'],
      'master_tax' => $data['master_tax'],
      'master_total' => $data['master_total'],
      'payment_limit' => $data['payment_limit'],
      'bill_company' => !empty($data['bill_company']) ? $data['bill_company'] : "",
      'bill_person' => $data['bill_person'],
      'bill_created_at' => $data['bill_created_at'],
      'bill_remark' => !empty($data['bill_remark']) ? $data['bill_remark'] : "",
      'paid' => $data['paid'],
      'pay_day' => $data['pay_day'],
      'pay_person' => $data['pay_person'],
      'payment' => $data['payment'],
      'reservation_status' => $reservation_status,
      'double_check_status' => $double_check_status,
      'double_check1_name' => !empty($data['double_check1_name']) ? $data['double_check1_name'] : "",
      'double_check2_name' => !empty($data['double_check2_name']) ? $data['double_check2_name'] : "",
      'approve_send_at' => !empty($data['approve_send_at']) ? $data['approve_send_at'] : NULL,
      'category' => !empty($data['category']) ? $data['category'] : $category,
      'admin_judge' => $admin_judge,
      'end_user_charge' => !empty($data['end_user_charge']) ? $data['end_user_charge'] : NULL,
      'invoice_number' => $this->generateInvoiceNum(),
    ]);
    return $result;
  }

  public function BillUpdate($data, $reservation_status = 1, $double_check_status = 0, $category = 1, $admin_judge = 1)
  {
    $this->update([
      'venue_price' => !empty($data['venue_price']) ? $data['venue_price'] : 0,
      'equipment_price' => !empty($data['equipment_price']) ? $data['equipment_price'] : 0,
      'layout_price' => !empty($data['layout_price']) ? $data['layout_price'] : 0,
      'others_price' => !empty($data['others_price']) ? $data['others_price'] : 0,
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
      'reservation_status' => $reservation_status,
      'double_check_status' => $double_check_status,
      // 'double_check1_name' => !empty($data['double_check1_name']) ? $data['double_check1_name'] : "",
      // 'double_check2_name' => !empty($data['double_check2_name']) ? $data['double_check2_name'] : "",
      'approve_send_at' => !empty($data['approve_send_at']) ? $data['approve_send_at'] : NULL,
      'category' => $category,
      'admin_judge' => $admin_judge,
      'end_user_charge' => !empty($data['end_user_charge']) ? $data['end_user_charge'] : NULL,
      'invoice_number' => $this->generateInvoiceNum(),
    ]);
    return $this;
  }

  public function BillUpdateCxlStatus($reservation_id)
  {
    $bills = $this->where('reservation_id', $reservation_id)->where('reservation_status', 3)->get();
    foreach ($bills as $key => $value) {
      $value->updateStatusByCxl();
    }
  }


  public function RequestBreakdowns($request, $targetItem)
  {
    $array_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/' . $targetItem . '/', $key)) {
        if (!empty($value)) {
          $array_details[] = $value;
        }
      }
    }
    if (!empty($array_details)) {
      return count($array_details);
    } else {
      return "";
    }
  }


  public function checkBreakdowns()
  {
    $vnu = $this->breakdowns()->where("unit_type", 1)->get();
    $s_vnu = [];
    foreach ($vnu as $key => $value) {
      $s_vnu[] = $value;
    }
    $equ = $this->breakdowns()->where("unit_type", 2)->get();
    $s_equ = [];
    foreach ($equ as $key => $value) {
      $s_equ[] = $value;
    }
    $ser = $this->breakdowns()->where("unit_type", 3)->get();
    $s_ser = [];
    foreach ($ser as $key => $value) {
      $s_ser[] = $value;
    }
    $lay = $this->breakdowns()->where("unit_type", 4)->get();
    $s_lay = [];
    foreach ($lay as $key => $value) {
      $s_lay[] = $value;
    }
    $other = $this->breakdowns()->where("unit_type", 4)->get();
    $s_other = [];
    foreach ($other as $key => $value) {
      $s_other[] = $value;
    }

    return [
      [count($s_equ), count($s_ser), count($s_lay), count($s_other)],
      [$s_vnu, $s_equ, $s_ser, $s_lay, $s_other],
    ];
  }

  public function getCxlPrice($request)
  {
    $venueCxl = $this->checkCxlInput($request, 'cxl_venue_PC', $this->venue_price);
    $equipmentCxl = $this->checkCxlInput($request, 'cxl_equipment_PC', $this->equipment_price);
    $layoutCxl = $this->checkCxlInput($request, 'cxl_layout_PC', $this->layout_price);
    $otherCxl = $this->checkCxlInput($request, 'cxl_other_PC', $this->others_price);

    $subtotal = (int) $venueCxl + (int) $equipmentCxl + (int) $layoutCxl + (int) $otherCxl;
    return [$venueCxl, $equipmentCxl, $layoutCxl, $otherCxl, $subtotal];
    // 0会場　1備品　2レイアウト　3その他 4合計額
  }

  public function checkCxlInput($request, $targetName, $price)
  {
    if (!empty($request->{$targetName})) {
      $target = $price;
      $percent = $request->{$targetName};
      $cxl = $target * ($percent * 0.01);
      return floor($cxl);
    } else {
      return "";
    }
  }

  public function updateStatusByCxl()
  {
    $this->update(['reservation_status' => 4]);
  }
}
