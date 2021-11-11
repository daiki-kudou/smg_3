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
    'cfm_at',
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
      'cfm_at' => !empty($data['cfm_at']) ? $data['cfm_at'] : NULL,
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

  public function CSVSearchTarget()
  {
    $searchTarget = DB::table('reservations')
      ->select(DB::raw(
        "
        LPAD(reservations.id, 6, 0) as reservation_id,
        reservations.id as original_reservation_id,
        LPAD(reservations.multiple_reserve_id,6,0) as multiple_reserve_id,
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
        reservations.board_flag,
        reservations.venue_id as venue_id,
        reservations.eat_in as eat_in,
        concat(venues.name_area,venues.name_bldg,venues.name_venue) as venue_name, 
        case when venues.alliance_flag = 0 then '直' when venues.alliance_flag = 1 then '提' end as alliance_flag,
        users.company as company_name,
        concat(users.first_name, users.last_name) as user_name, 
        users.mobile as mobile,
        users.tel as tel,
        case 
        when users.attr = 1 then '一般企業' 
        when users.attr = 2 then '上場企業'
        when users.attr = 3 then '近隣利用'
        when users.attr = 4 then '個人講師'
        when users.attr = 5 then 'MLM'
        when users.attr = 6 then 'その他'
        end as attr,
        LPAD(users.id,6,0) as user_id,
        agents.name as agent_name,
        agents.id as agent_id,
        endusers.company as enduser_company,
        bills.master_total as bills_master_total,
        case when bills.category = 1 then '会場予約' when bills.category = 2 then '追加' end as bill_category,
        bills.reservation_status as reservation_status,
        concat(date_format(bills.pay_day, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(reservations.reserve_date) = 1 then '(日)' 
        when DAYOFWEEK(reservations.reserve_date) = 2 then '(月)'
        when DAYOFWEEK(reservations.reserve_date) = 3 then '(火)'
        when DAYOFWEEK(reservations.reserve_date) = 4 then '(水)'
        when DAYOFWEEK(reservations.reserve_date) = 5 then '(木)'
        when DAYOFWEEK(reservations.reserve_date) = 6 then '(金)'
        when DAYOFWEEK(reservations.reserve_date) = 7 then '(土)'
        end
        ) as pay_day,
        bills.pay_person as pay_person,
        case
        when bills.paid = 0 then '未入金'
        when bills.paid = 1 then '入金済'
        when bills.paid = 2 then '遅延'
        when bills.paid = 3 then '入金不足'
        when bills.paid = 4 then '入金過多'
        when bills.paid = 5 then '次回繰越'
        end as paid,
        concat(date_format(bills.payment_limit, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(bills.payment_limit) = 1 then '(日)' 
        when DAYOFWEEK(bills.payment_limit) = 2 then '(月)'
        when DAYOFWEEK(bills.payment_limit) = 3 then '(火)'
        when DAYOFWEEK(bills.payment_limit) = 4 then '(水)'
        when DAYOFWEEK(bills.payment_limit) = 5 then '(木)'
        when DAYOFWEEK(bills.payment_limit) = 6 then '(金)'
        when DAYOFWEEK(bills.payment_limit) = 7 then '(土)'
        end
        ) as payment_limit,
        case 
        when bills.reservation_status <= 3 then 0 else 1 end as 予約中かキャンセルか,
        case 
        when reservations.reserve_date >= CURRENT_DATE then 0 else 1 end as 今日以降かどうか,
        case 
        when reservations.reserve_date >= CURRENT_DATE then reserve_date end as 今日以降日付,
        case 
        when reservations.reserve_date < CURRENT_DATE then reserve_date end as 今日未満日付,
        check_unit_2.master_unit_2 as unit_type2,
        check_unit_3.master_unit_3 as unit_type3,
        check_unit_4.master_unit_4 as unit_type4,
        check_status1.status1 as reservation_status1,
        check_status2.status2 as reservation_status2,
        check_status3.status3 as reservation_status3,
        check_status4.status4 as reservation_status4,
        check_status5.status5 as reservation_status5,
        check_status6.status6 as reservation_status6,
        format(sogaku_master.sogaku,0) as sogaku,
        format(bills.master_total,0) as master_total,
        case 
        when bills.category = 1 then '会場予約' when bills.category = 2 then '追加' end as category,
        case 
        when bills.reservation_status = 0 then '仮抑え'
        when bills.reservation_status = 1 then '予約確認中'
        when bills.reservation_status = 2 then '予約承認待ち'
        when bills.reservation_status = 3 then '予約完了'
        when bills.reservation_status = 4 then 'キャンセル申請中'
        when bills.reservation_status = 5 then 'キャンセル承認待ち'
        when bills.reservation_status = 6 then 'キャンセル'
        end as reservation_status,
        concat(date_format(bills.pay_day, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(bills.pay_day) = 1 then '(日)' 
        when DAYOFWEEK(bills.pay_day) = 2 then '(月)'
        when DAYOFWEEK(bills.pay_day) = 3 then '(火)'
        when DAYOFWEEK(bills.pay_day) = 4 then '(水)'
        when DAYOFWEEK(bills.pay_day) = 5 then '(木)'
        when DAYOFWEEK(bills.pay_day) = 6 then '(金)'
        when DAYOFWEEK(bills.pay_day) = 7 then '(土)'
        end
        ) as pay_day,
        cxls.id as cxl_id,
        format(cxls.master_total,0) as cxl_master_total,
        case 
        when cxls.cxl_status = 0 then 'キャンセル申請中' 
        when cxls.cxl_status = 1 then 'キャンセル承認待ち' 
        when cxls.cxl_status = 2 then 'キャンセル' 
        end as cxl_status,
        cxls.pay_day as cxl_pay_day,
        case
        when cxls.paid = 0 then '未入金'
        when cxls.paid = 1 then '入金済'
        when cxls.paid = 2 then '遅延'
        when cxls.paid = 3 then '入金不足'
        when cxls.paid = 4 then '入金過多'
        when cxls.paid = 5 then '次回繰越'
        end as cxl_paid,
        cxls.pay_person as cxl_pay_person,
        concat(date_format(cxls.payment_limit, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(cxls.payment_limit) = 1 then '(日)' 
        when DAYOFWEEK(cxls.payment_limit) = 2 then '(月)'
        when DAYOFWEEK(cxls.payment_limit) = 3 then '(火)'
        when DAYOFWEEK(cxls.payment_limit) = 4 then '(水)'
        when DAYOFWEEK(cxls.payment_limit) = 5 then '(木)'
        when DAYOFWEEK(cxls.payment_limit) = 6 then '(金)'
        when DAYOFWEEK(cxls.payment_limit) = 7 then '(土)'
        end
        ) as cxl_payment_limit
      "
      ))
      ->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
      ->leftJoin('endusers', 'reservations.id', '=', 'endusers.reservation_id')
      ->leftJoin('venues', 'reservations.venue_id', '=', 'venues.id')
      ->leftJoin(DB::raw('(select reservation_id , count(breakdowns.count_unit) as master_unit_2  from bills left join (select bill_id, count(unit_type) as count_unit from breakdowns where unit_type=2 group by bill_id) as breakdowns on bills.id=breakdowns.bill_id group by reservation_id) as check_unit_2'), 'reservations.id', '=', 'check_unit_2.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id , count(breakdowns.count_unit) as master_unit_3  from bills left join (select bill_id, count(unit_type) as count_unit from breakdowns where unit_type=3 group by bill_id) as breakdowns on bills.id=breakdowns.bill_id group by reservation_id) as check_unit_3'), 'reservations.id', '=', 'check_unit_3.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id , count(breakdowns.count_unit) as master_unit_4  from bills left join (select bill_id, count(unit_type) as count_unit from breakdowns where unit_type=4 group by bill_id) as breakdowns on bills.id=breakdowns.bill_id group by reservation_id) as check_unit_4'), 'reservations.id', '=', 'check_unit_4.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status1 from bills where reservation_status = 1  group by reservation_id) as check_status1'), 'reservations.id', '=', 'check_status1.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status2 from bills where reservation_status = 2  group by reservation_id) as check_status2'), 'reservations.id', '=', 'check_status2.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status3 from bills where reservation_status = 3  group by reservation_id) as check_status3'), 'reservations.id', '=', 'check_status3.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status4 from bills where reservation_status = 4  group by reservation_id) as check_status4'), 'reservations.id', '=', 'check_status4.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status5 from bills where reservation_status = 5  group by reservation_id) as check_status5'), 'reservations.id', '=', 'check_status5.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status6 from bills where reservation_status = 6  group by reservation_id) as check_status6'), 'reservations.id', '=', 'check_status6.reservation_id')
      ->leftJoin(DB::raw('(select reservation_id, sum(master_total) as sogaku from bills group by reservation_id) as sogaku_master'), 'reservations.id', '=', 'sogaku_master.reservation_id')
      ->leftJoin('cxls', 'reservations.id', "=", "cxls.reservation_id");

    return $searchTarget;
  }

  public function CSVSearch($data)
  {
    $searchTarget = $this->CSVSearchTarget();

    if (!empty($data['multiple_id']) && (int)$data['multiple_id'] > 0) {
      for ($i = 0; $i < strlen($data['multiple_id']); $i++) {
        if ((int)$data['multiple_id'][$i] !== 0) {
          $id = strstr($data['multiple_id'], $data['multiple_id'][$i]);
          break;
        }
      }
      $searchTarget->whereRaw('reservations.multiple_reserve_id = ? ', [$id]);
    }

    if (!empty($data['search_id']) && (int)$data['search_id'] > 0) {
      // for ($i = 0; $i < strlen($data['search_id']); $i++) {
      //   if ((int)$data['search_id'][$i] !== 0) {
      //     $id = strstr($data['search_id'], $data['search_id'][$i]);
      //     break;
      //   }
      // }
      $searchTarget->whereRaw('reservations.id LIKE ? ',  ['%' . $data['search_id'] . '%']);
    }

    if (!empty($data['user_id']) && (int)$data['user_id'] > 0) {
      for ($i = 0; $i < strlen($data['user_id']); $i++) {
        if ((int)$data['user_id'][$i] !== 0) {
          $id = strstr($data['user_id'], $data['user_id'][$i]);
          break;
        }
      }
      $searchTarget->whereRaw('users.id = ?', [$id]);
    }

    if (!empty($data['reserve_date'])) {
      $targetData = explode(" ~ ", $data['reserve_date']);
      $searchTarget->whereRaw('reservations.reserve_date between ? AND ? ',  $targetData);
    }

    if (!empty($data['enter_time'])) {
      $searchTarget->whereRaw('reservations.enter_time >= ? ',  $data['enter_time']);
    }

    if (!empty($data['leave_time'])) {
      $searchTarget->whereRaw('reservations.leave_time <= ? ',  $data['leave_time']);
    }

    if (!empty($data['venue_id'])) {
      $searchTarget->whereRaw('reservations.venue_id = ? ',  [$data['venue_id']]);
    }

    if (!empty($data['company'])) {
      $searchTarget->whereRaw('users.company LIKE ? ',  ['%' . $data['company'] . '%']);
    }

    if (!empty($data['person_name'])) {
      $searchTarget->whereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['person_name'] . '%']);
    }

    if (!empty($data['search_mobile'])) {
      $searchTarget->whereRaw('users.mobile LIKE ? ',  ['%' . $data['search_mobile'] . '%']);
    }

    if (!empty($data['search_tel'])) {
      $searchTarget->whereRaw('users.tel LIKE ? ',  ['%' . $data['search_tel'] . '%']);
    }

    if (!empty($data['agent'])) {
      $searchTarget->whereRaw('agents.id = ? ',  [$data['agent']]);
    }

    if (!empty($data['enduser_person'])) {
      $searchTarget->whereRaw('endusers.company LIKE ? ',  ['%' . $data['enduser_person'] . '%']);
    }

    if (!empty($data['sogaku'])) {
      $searchTarget->whereRaw('sogaku = ?', [$data['sogaku']]);
    }

    if (!empty($data['payment_limit'])) {
      $date = explode(' ~ ', $data['payment_limit']);
      $searchTarget = $searchTarget->where(function ($query) use ($date) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('payment_limit between ? and ?', $date)->groupBy('reservation_id'))
          ->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('payment_limit between ? and ?', $date)->groupBy('reservation_id'));
      });
    }

    if (!empty($data['pay_day'])) {
      $date = explode(' ~ ', $data['pay_day']);
      $searchTarget = $searchTarget->where(function ($query) use ($date) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('pay_day between ? and ?', $date)->groupBy('reservation_id'))
          ->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('pay_day between ? and ?', $date)->groupBy('reservation_id'));
      });
    }

    if (!empty($data['pay_person'])) {
      $searchTarget = $searchTarget->where(function ($query) use ($data) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('pay_person LIKE ?', '%' . $data['pay_person'] . '%')->groupBy('reservation_id'))
          ->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('pay_person LIKE ?', '%' . $data['pay_person'] . '%')->groupBy('reservation_id'));
      });
    }

    if (!empty($data['attr'])) {
      $searchTarget->whereRaw('users.attr = ?', [$data['attr']]);
    }

    if (!empty($data['day_before'])) {
      $yesterday = new Carbon('yesterday');
      $searchTarget->whereRaw('reservations.reserve_date = ?', [date('Y-m-d', strtotime($yesterday))]);
    }
    if (!empty($data['today'])) {
      $yesterday = new Carbon('today');
      $searchTarget->whereRaw('reservations.reserve_date = ?', [date('Y-m-d', strtotime($yesterday))]);
    }
    if (!empty($data['day_after'])) {
      $yesterday = new Carbon('tomorrow');
      $searchTarget->whereRaw('reservations.reserve_date = ?', [date('Y-m-d', strtotime($yesterday))]);
    }


    // チェックボックス
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['alliance0'])) {
        $query->orWhereRaw('alliance_flag = ? ', [0]);
      }
      if (!empty($data['alliance1'])) {
        $query->orWhereRaw('alliance_flag = ? ', [1]);
      }
    });

    // アイコン
    if (!empty($data['check_icon1']) && (int)$data['check_icon1'] === 1) {
      $searchTarget->orWhereRaw('check_unit_2.master_unit_2 >= ? ', [1]);
    }
    if (!empty($data['check_icon2']) && (int)$data['check_icon2'] === 1) {
      $searchTarget->orWhereRaw('check_unit_3.master_unit_3 >= ? ', [1]);
    }
    if (!empty($data['check_icon3']) && (int)$data['check_icon3'] === 1) {
      $searchTarget->orWhereRaw('check_unit_4.master_unit_4 >= ? ', [1]);
    }
    if (!empty($data['check_icon4']) && (int)$data['check_icon4'] === 1) {
      $searchTarget->orWhereRaw('reservations.eat_in = ? ',  [1]);
    }

    // チェックボックス
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['check_status1']) && (int)$data['check_status1'] === 1) {
        $query->orWhereRaw('check_status1.status1 >= ? ', [1]);
      }
      if (!empty($data['check_status2']) && (int)$data['check_status2'] === 1) {
        $query->orWhereRaw('check_status2.status2 >= ? ', [1]);
      }
      if (!empty($data['check_status3']) && (int)$data['check_status3'] === 1) {
        $query->orWhereRaw('check_status3.status3 >= ? ', [1]);
      }
      if (!empty($data['check_status4']) && (int)$data['check_status4'] === 1) {
        $query->orWhereRaw('check_status4.status4 >= ? ', [1]);
      }
      if (!empty($data['check_status5']) && (int)$data['check_status5'] === 1) {
        $query->orWhereRaw('check_status5.status5 >= ? ', [1]);
      }
      if (!empty($data['check_status6']) && (int)$data['check_status6'] === 1) {
        $query->orWhereRaw('check_status6.status6 >= ? ', [1]);
      }
    });

    // チェックボックス 売上区分
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['sales1'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('category = ?', [1])->groupBy('reservation_id'));
      }
      if (!empty($data['sales2'])) {
        $query->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->groupBy('reservation_id'));
      }
      if (!empty($data['sales3'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('category = ?', [2])->groupBy('reservation_id'));
      }
    });

    // チェックボックス 入金状況
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['payment_status0'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [0])->groupBy('reservation_id'));
      }
      if (!empty($data['payment_status1'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [1])->groupBy('reservation_id'));
      }
      if (!empty($data['payment_status2'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [2])->groupBy('reservation_id'));
      }
      if (!empty($data['payment_status3'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [3])->groupBy('reservation_id'));
      }
      if (!empty($data['payment_status4'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [4])->groupBy('reservation_id'));
      }
      if (!empty($data['payment_status5'])) {
        $query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [5])->groupBy('reservation_id'));
      }
    });

    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['freeword'])) {
        for ($i = 0; $i < strlen($data['freeword']); $i++) {
          if ((int)$data['freeword'][$i] !== 0) {
            $id = strstr($data['freeword'], $data['freeword'][$i]);
            $query->orWhereRaw('reservations.id LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.multiple_reserve_id LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('users.mobile LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('users.tel LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.reserve_date LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.enter_time LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.leave_time LIKE ? ', ['%' . $id . '%']);
            break;
          }
        }
        // 利用会場
        $query->orWhereRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('users.company LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('concat(agents.person_firstname,agents.person_lastname) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('agents.name LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('endusers.company LIKE ? ',  ['%' . $data['freeword'] . '%']);
      }
    });

    return $searchTarget;
  }

  public function BillEmailTemplate($bill_id)
  {
    $result = DB::table('bills')
      ->select(DB::raw(
        "
        FORMAT(bills.master_total,0) as master_total,
        bills.payment_limit,
        concat(date_format(bills.payment_limit, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(bills.payment_limit) = 1 then '(日)' 
        when DAYOFWEEK(bills.payment_limit) = 2 then '(月)'
        when DAYOFWEEK(bills.payment_limit) = 3 then '(火)'
        when DAYOFWEEK(bills.payment_limit) = 4 then '(水)'
        when DAYOFWEEK(bills.payment_limit) = 5 then '(木)'
        when DAYOFWEEK(bills.payment_limit) = 6 then '(金)'
        when DAYOFWEEK(bills.payment_limit) = 7 then '(土)'
        end)as payment_limit,
        bills.invoice_number
        "
      ))
      ->whereRaw('bills.deleted_at is NULL')
      ->whereRaw('bills.id = ?', [$bill_id]);

    return $result->first();
  }
}
