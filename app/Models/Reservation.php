<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Venue;
use App\Models\User;
use App\Models\Cxl;
use App\Models\Enduser;
use Illuminate\Support\Collection;

use Carbon\Carbon;

use App\Presenters\ReservationPresenter;
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Traits\InvoiceTrait;
use App\Traits\SearchTrait;
use App\Traits\TransactionTrait;


class Reservation extends Model implements PresentableInterface
{
  use InvoiceTrait;
  use SearchTrait;
  use TransactionTrait;


  public function getPresenter() //実装したプレゼンタを利用
  {
    return new ReservationPresenter($this);
  }

  use SoftDeletes; //reservation大事なのでソフトデリートする

  protected $fillable = [
    'venue_id',
    'user_id',
    'agent_id',
    'reserve_date',
    'price_system',
    'enter_time',
    'leave_time',
    'event_start',
    'event_finish',
    'board_flag',
    'event_name1',
    'event_name2',
    'event_owner',
    'luggage_flag',
    'luggage_count',
    'luggage_arrive',
    'luggage_return',
    'luggage_price',
    'email_flag',
    'in_charge',
    'tel',
    'email_send',
    'cost',
    'discount_condition',
    'attention',
    'user_details',
    'admin_details',
    'payment_limit',
    'reservation_status',
    'double_check_status',
    'double_check1_name',
    'double_check2_name',
    'bill_company',
    'bill_person',
    'bill_created_at',
    'bill_pay_limit',
    'bill_remark',
    'eat_in',
    'eat_in_prepare',
    'multiple_reserve_id',

  ];
  protected $dates = [
    'reserve_date',
    'payment_limit',
    'bill_created_at',
    'bill_pay_limit',
    'luggage_arrive'
  ];
  //formatで使用できるようにするため 参考https://readouble.com/laravel/6.x/ja/eloquent-mutators.html


  /*
|--------------------------------------------------------------------------
| 顧客との一対多
|--------------------------------------------------------------------------|
*/
  public function user()
  {
    return $this->belongsTo(User::class)->withTrashed();
  }

  /*
|--------------------------------------------------------------------------
| 会場との一対多
|--------------------------------------------------------------------------|
*/
  public function venue()
  {
    return $this->belongsTo(Venue::class);
  }

  /*
|--------------------------------------------------------------------------
| Billsとの一対多
|--------------------------------------------------------------------------|
*/
  public function bills()
  {
    return $this->hasMany(Bill::class);
  }
  /*
|--------------------------------------------------------------------------
| Billsを経由してbreakdowns
|--------------------------------------------------------------------------|
*/
  public function breakdowns()
  {
    return $this->hasManyThrough(
      'App\Models\Breakdown',
      'App\Models\Bill',
    );
  }

  /*
|--------------------------------------------------------------------------
| 仲介会社との一対多
|--------------------------------------------------------------------------|
*/
  public function agent()
  {
    return $this->belongsTo(Agent::class);
  }

  // cxl一対多
  public function cxls()
  {
    return $this->hasMany(Cxl::Class);
  }

  public function endusers()
  {
    return $this->hasOne(Enduser::Class);
  }

  public function change_log()
  {
    return $this->hasOne('App\Models\ChangeLog');
  }


  // bills 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->bills()->get() as $child) {
        $child->delete();
      }
    });
  }



  public function addAllBills()
  {
    $bills = $this->bills()->get();
    $result_subtotal = 0;
    foreach ($$bills as $key => $value) {
      $result_subtotal += $value->sub_total;
    }
    return $result_subtotal;
  }

  //  管理者予約保存
  public function ReservationStore($data)
  {
    $chkReservation = ($this->checkReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
    $chkPreReservation = ($this->checkPreReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
    if (!$chkReservation || !$chkPreReservation) {
      return "重複";
    }
    $result = $this->create([
      'venue_id' => $data['venue_id'],
      'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
      'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
      'reserve_date' => $data['reserve_date'],
      'price_system' => $data['price_system'],
      'enter_time' => $data['enter_time'],
      'leave_time' => $data['leave_time'],
      'board_flag' => $data['board_flag'],
      'event_start' => $data['event_start'] ?? "",
      'event_finish' => $data['event_finish'] ?? "",
      'event_name1' => $data['event_name1'] ?? "",
      'event_name2' => $data['event_name2'] ?? "",
      'event_owner' => $data['event_owner'] ?? "",
      'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] : 0,
      'luggage_price' => !empty($data['luggage_price']) ? $data['luggage_price'] : 0,
      'luggage_count' => !empty($data['luggage_count']) ? $data['luggage_count'] : 0,
      'luggage_arrive' => !empty($data['luggage_arrive']) ? $data['luggage_arrive'] : NULL,
      'luggage_return' => !empty($data['luggage_return']) ? $data['luggage_return'] : NULL,
      'email_flag' => $data['email_flag'],
      'in_charge' => $data['in_charge'],
      'tel' => !empty($data['tel']) ? $data['tel'] : "",
      'cost' => !empty($data['cost']) ? $data['cost'] : 0,
      'discount_condition' => $data['discount_condition'] ?? "",
      'attention' => $data['attention'] ?? "",
      'user_details' => $data['user_details'] ?? "",
      'admin_details' => $data['admin_details'] ?? "",
      'eat_in' => !empty($data['eat_in']) ? $data['eat_in'] : 0,
      'eat_in_prepare' => !empty($data['eat_in_prepare']) ? $data['eat_in_prepare'] : 0,
      'multiple_reserve_id' => !empty($data['multiple_reserve_id']) ? $data['multiple_reserve_id'] : 0,

    ]);
    return $result;
  }

  public function ReservationUpdate($data)
  {
    $chkReservation = ($this->checkReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id'], $data['reservation_id']));
    $chkPreReservation = ($this->checkPreReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
    if (!$chkReservation || !$chkPreReservation) {
      return "重複";
    }
    $this->update([
      'venue_id' => $data['venue_id'],
      'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
      'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
      'reserve_date' => $data['reserve_date'],
      'price_system' => $data['price_system'],
      'enter_time' => $data['enter_time'],
      'leave_time' => $data['leave_time'],
      'board_flag' => $data['board_flag'],
      'event_start' => !empty($data['event_start']) ? $data['event_start'] : "",
      'event_finish' => !empty($data['event_finish']) ? $data['event_finish'] : "",
      'event_name1' => !empty($data['event_name1']) ? $data['event_name1'] : "",
      'event_name2' => !empty($data['event_name2']) ? $data['event_name2'] : "",
      'event_owner' => !empty($data['event_owner']) ? $data['event_owner'] : "",
      'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] : 0,
      'luggage_price' => !empty($data['luggage_price']) ? $data['luggage_price'] : 0,
      'luggage_count' => $data['luggage_count'],
      'luggage_arrive' => $data['luggage_arrive'],
      'luggage_return' => $data['luggage_return'],
      'email_flag' => !empty($data['email_flag']) ? $data['email_flag'] : 1,
      'in_charge' => !empty($data['in_charge']) ? $data['in_charge'] : "",
      'tel' => !empty($data['tel']) ? $data['tel'] : "",
      'cost' => !empty($data['cost']) ? $data['cost'] : 0,
      'discount_condition' => $data['discount_condition'] ?? "",
      'attention' => $data['attention'] ?? "",
      'user_details' => $data['user_details'] ?? "",
      'admin_details' => $data['admin_details'] ?? "",
      'eat_in' => $data['eat_in'],
      'eat_in_prepare' => !empty($data['eat_in_prepare']) ? $data['eat_in_prepare'] :  0,
      'multiple_reserve_id' => $data['multiple_reserve_id'] ?? 0,
    ]);
    return $this;
  }
  // session利用
  // public function ReserveStoreSession($request, $sessionName, $sessionName2)
  // {
  //   $master_info = $request->session()->get($sessionName);
  //   $reservation = DB::transaction(function () use ($master_info, $request, $sessionName2) { //トランザクションさせる
  //     $reservation = $this->create([
  //       'venue_id' => $master_info['venue_id'],
  //       'user_id' => $master_info['user_id'],
  //       'agent_id' => 0, //デフォで0
  //       'reserve_date' => $master_info['reserve_date'],
  //       'price_system' => $master_info['price_system'],
  //       'enter_time' => $master_info['enter_time'],
  //       'leave_time' => $master_info['leave_time'],
  //       'board_flag' => $master_info['board_flag'],
  //       'event_start' => !empty($master_info['event_start']) ? $master_info['event_start'] : null,
  //       'event_finish' => !empty($master_info['event_finish']) ? $master_info['event_finish'] : null,
  //       'event_name1' => !empty($master_info['event_name1']) ? $master_info['event_name1'] : null,
  //       'event_name2' => !empty($master_info['event_name2']) ? $master_info['event_name2'] : null,
  //       'event_owner' => !empty($master_info['event_owner']) ? $master_info['event_owner'] : null,
  //       'luggage_count' => !empty($master_info['luggage_count']) ? $master_info['luggage_count'] : null,
  //       'luggage_arrive' => !empty($master_info['luggage_arrive']) ? $master_info['luggage_arrive'] : null,
  //       'luggage_return' => !empty($master_info['luggage_return']) ? $master_info['luggage_return'] : null,
  //       'email_flag' => $master_info['email_flag'],
  //       'in_charge' => $master_info['in_charge'],
  //       'tel' => $master_info['tel'],
  //       'cost' => !empty($master_info['cost']) ? $master_info['cost'] : 0,
  //       'discount_condition' => "",
  //       'attention' => "",
  //       'user_details' => $master_info['user_details'],
  //       'admin_details' => $master_info['admin_details'],
  //       'eat_in' => !empty($master_info['eat_in']) ? $master_info['eat_in'] : 0,
  //       'eat_in_prepare' => !empty($master_info['eat_in_prepare']) ? $master_info['eat_in_prepare'] : 0,
  //     ]);
  //     // $reservation->ReserveStoreSessionBill($request, $sessionName2, $sessionName2);
  //     return $reservation;
  //   });
  //   return $reservation;
  // }
  // session利用
  // public function ReserveStoreSessionBill($request, $sessionName, $sessionName2, $attr = "normal")
  // {
  //   $discount_info = $request->session()->get($sessionName);
  //   if ($attr == "add") {
  //     $venue_price = !empty($discount_info['venue_price']) ? $discount_info['venue_price'] : 0;
  //     $category = 2;
  //   } else {
  //     $venue_price = $discount_info['venue_price'];
  //     $category = 1;
  //   }
  //   // 以下、請求書No作成用
  //   $bill = DB::transaction(function () use ($discount_info, $request, $sessionName2, $attr, $venue_price, $category) {
  //     $bill = $this->bills()->create([
  //       'reservation_id' => $this->id,
  //       'venue_price' => $venue_price,
  //       'equipment_price' => !empty($discount_info['equipment_price']) ? $discount_info['equipment_price'] : 0, //備品・サービス・荷物
  //       'layout_price' => !empty($discount_info['layout_price']) ? $discount_info['layout_price'] : 0,
  //       'others_price' => !empty($discount_info['others_price']) ? $discount_info['others_price'] : 0,
  //       'master_subtotal' => $discount_info['master_subtotal'],
  //       'master_tax' => $discount_info['master_tax'],
  //       'master_total' => $discount_info['master_total'],
  //       'payment_limit' => $discount_info['pay_limit'],
  //       'bill_company' => $discount_info['pay_company'],
  //       'bill_person' => $discount_info['bill_person'],
  //       'bill_created_at' => Carbon::now(),
  //       'bill_remark' => $discount_info['bill_remark'],
  //       'paid' => $discount_info['paid'],
  //       'pay_day' => $discount_info['pay_day'],
  //       'pay_person' => $discount_info['pay_person'],
  //       'payment' => $discount_info['payment'],
  //       'reservation_status' => 1, //デフォで1、仮押えのデフォは0
  //       'double_check_status' => 0, //デフォで0
  //       'category' => $category, //デフォで１。新規以外だと2:その他有料備品3:レイアウト4:その他
  //       'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
  //       'invoice_number' => $this->generateInvoiceNum(),
  //     ]);
  //     // $bill->ReserveStoreSessionBreakdown($request, $sessionName2);
  //     return $bill;
  //   });
  //   return $bill;
  // }

  // public function ReserveStore($request, $agent_id = 0)
  // {
  //   DB::transaction(function () use ($request, $agent_id) { //トランザクションさせる
  //     $reservation = $this->create([
  //       'venue_id' => $request->venue_id,
  //       'user_id' => $request->user_id,
  //       'agent_id' => $agent_id,
  //       'reserve_date' => $request->reserve_date,
  //       'price_system' => $request->price_system,
  //       'enter_time' => $request->enter_time,
  //       'leave_time' => $request->leave_time,
  //       'board_flag' => $request->board_flag,
  //       'event_start' => $request->event_start,
  //       'event_finish' => $request->event_finish,
  //       'event_name1' => $request->event_name1,
  //       'event_name2' => $request->event_name2,
  //       'event_owner' => $request->event_owner,
  //       'luggage_count' => $request->luggage_count,
  //       'luggage_arrive' => $request->luggage_arrive,
  //       'luggage_return' => $request->luggage_return,
  //       'email_flag' => $request->email_flag,
  //       'in_charge' => $request->in_charge,
  //       'tel' => $request->tel,
  //       'cost' => !empty($request->cost) ? $request->cost : 0,
  //       'discount_condition' => $request->discount_condition,
  //       'attention' => $request->attention,
  //       'user_details' => $request->user_details,
  //       'admin_details' => $request->admin_details,
  //       'eat_in' => !empty($request->eat_in) ? $request->eat_in : 0,
  //       'eat_in_prepare' => !empty($request->eat_in_prepare) ? $request->eat_in_prepare : 0,
  //       'multiple_reserve_id' => ($request->multiple_reserve_id)
  //     ]);
  //     $reservation->ReserveStoreBill($request);
  //   });
  // }

  // public function ReserveStoreBill($request)
  // {
  //   DB::transaction(function () use ($request) {
  //     $bill = $this->bills()->create([
  //       'reservation_id' => $this->id,
  //       'venue_price' => $request->venue_price,
  //       'equipment_price' => $request->equipment_price ? $request->equipment_price : 0, //備品・サービス・荷物
  //       'layout_price' => $request->layout_price ? $request->layout_price : 0,
  //       'others_price' => $request->others_price ? $request->others_price : 0,
  //       'master_subtotal' => $request->master_subtotal,
  //       'master_tax' => $request->master_tax,
  //       'master_total' => $request->master_total,
  //       'payment_limit' => $request->payment_limit,
  //       'bill_company' => $request->bill_company,
  //       'bill_person' => $request->bill_person,
  //       'bill_created_at' => Carbon::now(),
  //       'bill_remark' => $request->bill_remark,
  //       'paid' => $request->paid,
  //       'pay_day' => $request->pay_day,
  //       'pay_person' => $request->pay_person,
  //       'payment' => $request->payment,
  //       'reservation_status' => 1, //デフォで1、仮押えのデフォは0
  //       'double_check_status' => 0, //デフォで0
  //       'category' => 1, //デフォで１。新規以外だと2:その他有料備品3:レイアウト4:その他
  //       'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
  //       'invoice_number' => $this->generateInvoiceNum(),

  //     ]);
  //     $bill->ReserveStoreBreakdown($request);
  //   });
  // }

  /*
|--------------------------------------------------------------------------
| ユーザーからの予約
|--------------------------------------------------------------------------|
*/
  // public function ReserveFromUser($value, $user)
  // {
  //   $venue = Venue::find($value->venue_id);
  //   $s_user = User::find($user);
  //   $payment_limit = $s_user->getUserPayLimit($value->date);
  //   $reservation = DB::transaction(function () use ($value, $user, $s_user, $venue, $payment_limit) {
  //     $reservation = $this->create([
  //       'venue_id' => $value->venue_id,
  //       'user_id' => $user,
  //       'agent_id' => 0, //デフォで0
  //       'reserve_date' => $value->date,
  //       'price_system' => $value->price_system,
  //       'enter_time' => $value->enter_time,
  //       'leave_time' => $value->leave_time,
  //       'board_flag' => $value->board_flag,
  //       'event_start' => $value->event_start ?? NULL,
  //       'event_finish' => $value->event_finish ?? NULL,
  //       'event_name1' => $value->event_name1 ?? NULL,
  //       'event_name2' => $value->event_name2 ?? NULL,
  //       'event_owner' => $value->event_owner ?? NULL,
  //       'luggage_count' => $value->luggage_count ?? NULL,
  //       'luggage_arrive' => $value->luggage_arrive ?? NULL,
  //       'luggage_return' => $value->luggage_return ?? NULL,
  //       'email_flag' => 0,
  //       'in_charge' => $value->in_charge,
  //       'tel' => $value->tel,
  //       'cost' => $value->cost ?? 0,
  //       'discount_condition' => NULL,
  //       'attention' => NULL,
  //       'user_details' => $value->remark ?? NULL,
  //       'admin_details' => NULL,
  //       'eat_in' => !empty($value->eat_in) ? $value->eat_in : 0,
  //       'eat_in_prepare' => !empty($value->eat_in_prepare) ? $value->eat_in_prepare : 0,
  //     ]);

  //     $layout_prepare = !empty($value->layout_prepare) ? $venue->layout_prepare : 0;
  //     $layout_clean = !empty($value->layout_clean) ? $venue->layout_clean : 0;
  //     $layout_sum = $layout_prepare + $layout_clean;
  //     $bills = $reservation->bills()->create([
  //       'reservation_id' => $reservation->id,
  //       'venue_price' => json_decode($value->price_result)[0],
  //       'equipment_price' => json_decode($value->items_results)[0] ? json_decode($value->items_results)[0] : 0, //備品・サービス・荷物
  //       'layout_price' => $layout_sum,
  //       'others_price' => 0,
  //       // 該当billの合計額関連
  //       'master_subtotal' => $value->master,
  //       'master_tax' => floor($value->master * 0.1),
  //       'master_total' => floor(($value->master * 0.1) + $value->master),
  //       'payment_limit' => $payment_limit,
  //       'bill_company' => $s_user->getCompany(),
  //       'bill_person' => $s_user->getPerson(),
  //       'bill_created_at' => Carbon::now(),
  //       'bill_remark' => "",
  //       'paid' => 0,
  //       'reservation_status' => 1, //デフォで1、仮押えのデフォは0
  //       'double_check_status' => 0, //デフォで0
  //       'category' => 1, //デフォで１。新規以外だと2:その他有料備品3:レイアウト4:その他
  //       'admin_judge' => 2, //管理者作成なら1 ユーザー作成なら2
  //       'invoice_number' => $this->generateInvoiceNum(),
  //     ]);

  //     // 料金内訳
  //     if (json_decode($value->price_result)[1] == 0) {
  //       $bills->breakdowns()->create([
  //         'unit_item' => "会場料金",
  //         'unit_cost' => json_decode($value->price_result)[0],
  //         'unit_count' => json_decode($value->price_result)[3] - json_decode($value->price_result)[4],
  //         'unit_subtotal' => json_decode($value->price_result)[0],
  //         'unit_type' => 1,
  //       ]);
  //     } else {
  //       $bills->breakdowns()->create([
  //         'unit_item' => "会場料金",
  //         'unit_cost' => json_decode($value->price_result)[0] - json_decode($value->price_result)[1],
  //         'unit_count' => json_decode($value->price_result)[3] - json_decode($value->price_result)[4],
  //         'unit_subtotal' => json_decode($value->price_result)[0],
  //         'unit_type' => 1,
  //       ]);
  //       $bills->breakdowns()->create([
  //         'unit_item' => "延長料金",
  //         'unit_cost' => json_decode($value->price_result)[1],
  //         'unit_count' => json_decode($value->price_result)[4],
  //         'unit_subtotal' => json_decode($value->price_result)[1],
  //         'unit_type' => 1,
  //       ]);
  //     }

  //     // 備品
  //     foreach (json_decode($value->items_results)[1] as $e_key => $equ) {
  //       $bills->breakdowns()->create([
  //         'unit_item' => $equ[0],
  //         'unit_cost' => $equ[1],
  //         'unit_count' => $equ[2],
  //         'unit_subtotal' => $equ[1] * $equ[2],
  //         'unit_type' => 2,
  //       ]);
  //     }
  //     // サービス
  //     foreach (json_decode($value->items_results)[2] as $s_key => $ser) {
  //       $bills->breakdowns()->create([
  //         'unit_item' => $ser[0],
  //         'unit_cost' => $ser[1],
  //         'unit_count' => 1,
  //         'unit_subtotal' => $ser[1],
  //         'unit_type' => 3,
  //       ]);
  //     }
  //     // 荷物
  //     // if (!empty($value->luggage_count) || !empty($value->luggage_arrive) || !empty($value->luggage_return)) {
  //     //   $bills->breakdowns()->create([
  //     //     'unit_item' => "荷物預かり",
  //     //     'unit_cost' => 500,
  //     //     'unit_count' => 3,
  //     //     'unit_subtotal' => 500,
  //     //     'unit_type' => 3,
  //     //   ]);
  //     // }
  //     // レイアウト準備
  //     if (!empty($value->layout_prepare)) {
  //       $bills->breakdowns()->create([
  //         'unit_item' => "レイアウト準備料金",
  //         'unit_cost' => $layout_prepare,
  //         'unit_count' => 1,
  //         'unit_subtotal' => $layout_prepare,
  //         'unit_type' => 4,
  //       ]);
  //     }
  //     // 片付
  //     if (!empty($value->layout_clean)) {
  //       $bills->breakdowns()->create([
  //         'unit_item' => "レイアウト片付料金",
  //         'unit_cost' => $layout_clean,
  //         'unit_count' => 1,
  //         'unit_subtotal' => $layout_clean,
  //         'unit_type' => 4,
  //       ]);
  //     }
  //     return $reservation;
  //   });
  //   return $reservation;
  // }

  // 仲介会社からの予約
  // public function ReserveFromAgent($request)
  // {
  //   DB::transaction(function () use ($request) {
  //     $reservation = $this->create([
  //       'venue_id' => $request->venue_id,
  //       'user_id' => 0, //デフォで0
  //       'agent_id' => $request->agent_id,
  //       'reserve_date' => $request->reserve_date,
  //       'price_system' => $request->price_system,
  //       'enter_time' => $request->enter_time,
  //       'leave_time' => $request->leave_time,
  //       'board_flag' => $request->board_flag,
  //       'event_start' => $request->event_start,
  //       'event_finish' => $request->event_finish,
  //       'event_name1' => $request->event_name1,
  //       'event_name2' => $request->event_name2,
  //       'event_owner' => $request->event_owner,
  //       'luggage_count' => $request->luggage_count,
  //       'luggage_arrive' => $request->luggage_arrive,
  //       'luggage_return' => $request->luggage_return,
  //       'email_flag' => 0,
  //       'in_charge' => '',
  //       'tel' => '',
  //       'cost' => !empty($request->cost) ? $request->cost : 0,
  //       'eat_in' => !empty($request->eat_in) ? $request->eat_in : 0,
  //       'eat_in_prepare' => !empty($request->eat_in_prepare) ? $request->eat_in_prepare : 0,
  //     ]);
  //     $reservation->CreateEndUser($request);
  //     $reservation->ReserveFromAgentBill($request);
  //   });
  // }

  public function CreateEndUser($request)
  {
    if (
      !empty($request->enduser_company) ||
      !empty($request->enduser_incharge) ||
      !empty($request->enduser_address) ||
      !empty($request->enduser_tel) ||
      !empty($request->enduser_mail) ||
      !empty($request->enduser_attr) ||
      !empty($request->end_user_charge) ||
      !empty($request->enduser_mobile)
    ) {
      DB::transaction(function () use ($request) {
        $this->enduser()->create([
          'reservation_id' => $this->id,
          'company' => $request->enduser_company,
          'person' => $request->enduser_incharge,
          'address' => $request->enduser_address,
          'tel' => $request->enduser_tel,
          'email' => $request->enduser_mail,
          'attr' => $request->enduser_attr,
          'charge' => $request->end_user_charge,
          'mobile' => $request->enduser_mobile,
        ]);
      });
    }
  }


  // 仲介会社選択の場合のみ、エンドユーザーとの一対一

  public function enduser()
  {
    return $this->hasOne(Enduser::class);
  }

  public function search_item($data)
  {
    $searchTarget = $this->ReservationSearchTarget();

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
      for ($i = 0; $i < strlen($data['search_id']); $i++) {
        if ((int)$data['search_id'][$i] !== 0) {
          $id = strstr($data['search_id'], $data['search_id'][$i]);
          break;
        }
      }
      $searchTarget->whereRaw('reservations.id LIKE ? ',  ['%' . $id . '%']);
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

    if (!empty($data['check_icon1'])) {
      $searchTarget->orWhereRaw('breakdowns2.unit_type = ? ',  [$data['check_icon1']]);
    }
    if (!empty($data['check_icon2'])) {
      $searchTarget->orWhereRaw('breakdowns3.unit_type = ? ',  [$data['check_icon2']]);
    }
    if (!empty($data['check_icon3'])) {
      $searchTarget->orWhereRaw('breakdowns4.unit_type = ? ',  [$data['check_icon3']]);
    }
    if (!empty($data['check_icon4'])) {
      $searchTarget->orWhereRaw('reservations.eat_in = ? ',  [1]);
    }

    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['check_status1'])) {
        $query->orWhereRaw('bills.reservation_status = ? ', [1]);
      }
      if (!empty($data['check_status2'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [2]);
      }
      if (!empty($data['check_status3'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [3]);
      }
      if (!empty($data['check_status4'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [4]);
      }
      if (!empty($data['check_status5'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [5]);
      }
      if (!empty($data['check_status6'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [6]);
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
        $query->orWhereRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('users.company LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('concat(agents.person_firstname,agents.person_lastname) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('agents.name LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('endusers.company LIKE ? ',  ['%' . $data['freeword'] . '%']);
      }
    });

    if (!empty($data['sort_id']) && (int)$data['sort_id'] === 1) {
      $searchTarget->orderByRaw('reservations.id asc');
    } elseif (!empty($data['sort_id']) && (int)$data['sort_id'] === 2) {
      $searchTarget->orderByRaw('reservations.id desc');
    } elseif (!empty($data['sort_reserve_date']) && (int)$data['sort_reserve_date'] === 1) {
      $searchTarget->orderByRaw('reservations.reserve_date asc');
    } elseif (!empty($data['sort_reserve_date']) && (int)$data['sort_reserve_date'] === 2) {
      $searchTarget->orderByRaw('reservations.reserve_date desc');
    } elseif (!empty($data['sort_enter_time']) && (int)$data['sort_enter_time'] === 1) {
      $searchTarget->orderByRaw('reservations.enter_time asc');
    } elseif (!empty($data['sort_enter_time']) && (int)$data['sort_enter_time'] === 2) {
      $searchTarget->orderByRaw('reservations.enter_time desc');
    } elseif (!empty($data['sort_leave_time']) && (int)$data['sort_leave_time'] === 1) {
      $searchTarget->orderByRaw('reservations.leave_time asc');
    } elseif (!empty($data['sort_leave_time']) && (int)$data['sort_leave_time'] === 2) {
      $searchTarget->orderByRaw('reservations.leave_time desc');
    } elseif (!empty($data['sort_venue']) && (int)$data['sort_venue'] === 1) {
      $searchTarget->orderByRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) asc');
    } elseif (!empty($data['sort_venue']) && (int)$data['sort_venue'] === 2) {
      $searchTarget->orderByRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) desc');
    } elseif (!empty($data['sort_user_company']) && (int)$data['sort_user_company'] === 1) {
      $searchTarget->orderByRaw('users.company asc');
    } elseif (!empty($data['sort_user_company']) && (int)$data['sort_user_company'] === 2) {
      $searchTarget->orderByRaw('users.company desc');
    } elseif (!empty($data['sort_user_name']) && (int)$data['sort_user_name'] === 1) {
      $searchTarget->orderByRaw('concat(users.first_name,users.last_name) asc');
    } elseif (!empty($data['sort_user_name']) && (int)$data['sort_user_name'] === 2) {
      $searchTarget->orderByRaw('concat(users.first_name,users.last_name) desc');
    } elseif (!empty($data['sort_user_mobile']) && (int)$data['sort_user_mobile'] === 1) {
      $searchTarget->orderByRaw('users.mobile asc');
    } elseif (!empty($data['sort_user_mobile']) && (int)$data['sort_user_mobile'] === 2) {
      $searchTarget->orderByRaw('users.mobile desc');
    } elseif (!empty($data['sort_user_tel']) && (int)$data['sort_user_tel'] === 1) {
      $searchTarget->orderByRaw('users.tel asc');
    } elseif (!empty($data['sort_user_tel']) && (int)$data['sort_user_tel'] === 2) {
      $searchTarget->orderByRaw('users.tel desc');
    } elseif (!empty($data['sort_agent']) && (int)$data['sort_agent'] === 1) {
      $searchTarget->orderByRaw('agents.name asc');
    } elseif (!empty($data['sort_agent']) && (int)$data['sort_agent'] === 2) {
      $searchTarget->orderByRaw('agents.name desc');
    } elseif (!empty($data['sort_enduser']) && (int)$data['sort_enduser'] === 1) {
      $searchTarget->orderByRaw('endusers.company asc');
    } elseif (!empty($data['sort_enduser']) && (int)$data['sort_enduser'] === 2) {
      $searchTarget->orderByRaw('endusers.company desc');
    } else {
      $searchTarget->orderByRaw('予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc');
    }




    return $searchTarget;
  }

  /**   
   * 予約一覧の検索対象マスタ
   * @return object collectionで返る
   */
  public function ReservationSearchTarget()
  {
    $searchTarget = DB::table('bills')
      ->select(DB::raw(
        'bills.id as bill_id,
      bills.reservation_status as bill_reserve_status,
      reservations.id as reservation_id,
      reservations.reserve_date as reserve_date,
      reservations.enter_time as enter_time,
      reservations.leave_time as leave_time,
      reservations.venue_id as venue_id,
      users.id as user_id,
      concat(users.first_name,users.last_name) as user_name,
      users.company as company,
      users.mobile as mobile,
      users.tel as tel,
      agents.id as agent_id,
      endusers.company as enduser,
      breakdowns2.unit_type as unit_type2,
      breakdowns3.unit_type as unit_type3,
      breakdowns4.unit_type as unit_type4,
      reservations.eat_in as eat_in,
      reservations.multiple_reserve_id as multiple_reserve_id,
      concat(venues.name_area,venues.name_bldg,venues.name_venue) as venue_name,
      case when bills.reservation_status <= 3 then 0 else 1 end as 予約中かキャンセルか,
      case when reservations.reserve_date >= CURRENT_DATE then 0 else 1 end as 今日以降かどうか,
      case when reservations.reserve_date >= CURRENT_DATE then reserve_date end as 今日以降日付,
      case when reservations.reserve_date < CURRENT_DATE then reserve_date end as 今日未満日付
      '
      ))
      ->leftJoin('reservations', 'bills.reservation_id', '=', 'reservations.id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
      ->leftJoin('endusers', 'bills.reservation_id', '=', 'endusers.reservation_id')
      ->leftJoin(DB::raw('(select bill_id, unit_type, unit_item from breakdowns where unit_type = 2) as breakdowns2'), 'bills.id', '=', 'breakdowns2.bill_id')
      ->leftJoin(DB::raw('(select bill_id, unit_type, unit_item from breakdowns where unit_type = 3) as breakdowns3'), 'bills.id', '=', 'breakdowns3.bill_id')
      ->leftJoin(DB::raw('(select bill_id, unit_type, unit_item from breakdowns where unit_type = 4) as breakdowns4'), 'bills.id', '=', 'breakdowns4.bill_id')
      ->leftJoin('venues', 'reservations.venue_id', '=', 'venues.id');
    // ->orderByRaw('予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc');

    return $searchTarget;
  }





  // reservations show 各請求書合計額
  public function TotalAmount()
  {
    $venues_master = 0;
    $items_master = 0;
    $layouts_master = 0;
    $others_master = 0;
    $master_subtotals = 0;
    $master_taxs = 0;
    $master_totals = 0;
    foreach ($this->bills->where('reservation_status', '<', 4) as $key => $value) {
      $venues_master += $value->venue_price;
      $items_master += $value->equipment_price;
      $layouts_master += $value->layout_price;
      $others_master += $value->others_price;
      $master_subtotals += $value->master_subtotal;
      $master_taxs += $value->master_tax;
      $master_totals += $value->master_total;
    }
    $all_master_subtotal = $venues_master + $items_master + $layouts_master + $others_master;
    return [
      $venues_master,
      $items_master,
      $layouts_master,
      $others_master,
      $all_master_subtotal
    ];
  }



  // reservations update
  // public function UpdateReservation($basicInfo, $result)
  // {
  //   DB::transaction(function () use ($basicInfo, $result) {
  //     $this->update([
  //       'user_id' => $basicInfo['user_id'],
  //       'agent_id' => 0, //デフォで0
  //       'price_system' => $basicInfo['price_system'],
  //       'enter_time' => $basicInfo['enter_time'],
  //       'leave_time' => $basicInfo['leave_time'],
  //       'board_flag' => $basicInfo['board_flag'],
  //       'event_start' => $basicInfo['event_start'] ?? NULL,
  //       'event_finish' => $basicInfo['event_finish'] ?? NULL,
  //       'event_name1' => $basicInfo['event_name1'] ?? NULL,
  //       'event_name2' => $basicInfo['event_name2'] ?? NULL,
  //       'event_owner' => $basicInfo['event_owner'] ?? NULL,
  //       'luggage_count' => $basicInfo['luggage_count'] ?? NULL,
  //       'luggage_arrive' => $basicInfo['luggage_arrive'] ?? NULL,
  //       'luggage_return' => $basicInfo['luggage_return'] ?? NULL,
  //       'email_flag' => $basicInfo['email_flag'],
  //       'in_charge' => $basicInfo['in_charge'],
  //       'tel' => $basicInfo['tel'],
  //       'cost' => !empty($basicInfo['cost']) ? $basicInfo['cost'] : 0,
  //       'admin_details' => $basicInfo['admin_details'],
  //       'eat_in' =>  $basicInfo['eat_in'] ?? 0,
  //       'eat_in_prepare' =>  $basicInfo['eat_in_prepare'] ?? 0,
  //     ]);
  //   });
  // }

  public function checkBillsStatus()
  {
    $collection = $this->bills->pluck('reservation_status');
    foreach ($collection as $key => $value) {
      if ($value < 3) {
        //ステータスが予約完了もしくはキャンセル完了していないキャンセルプロセスがあれば
        return 0;
        break;
      } elseif ($value > 3 && $value < 6) {
        return 0;
        break;
      }
    }
    return 1;
  }
  public function checkSingleBillsStatus()
  {
    $collection = $this->bills->pluck('reservation_status');
    foreach ($collection as $key => $value) {
      if ($value > 3 && $value != 6) {
        //ステータスが予約完了もしくはキャンセル完了していないキャンセルプロセスがあれば
        return 0;
        break;
      }
    }
    return 1;
  }

  public function pluckSum($array, $targetStatus)
  {
    $result = [];
    foreach ($array as $key => $value) {
      $result[] = $this->bills->where("reservation_status", $targetStatus)->pluck($value)->sum(); //予約ステータス3（予約完了）のみが対象
    }
    return $result;
  }

  // public function updateAgentReservation($inputs)
  // {
  //   $reservation = DB::transaction(function () use ($inputs) { //トランザクションさせる
  //     $reservation = $this->update([
  //       'agent_id' => $inputs['agent_id'],
  //       'price_system' => $inputs['price_system'],
  //       'enter_time' => $inputs['enter_time'],
  //       'leave_time' => $inputs['leave_time'],
  //       'board_flag' => $inputs['board_flag'],
  //       'event_start' => $inputs['event_start'] ?? NULL,
  //       'event_finish' => $inputs['event_finish'] ?? NULL,
  //       'event_name1' => $inputs['event_name1'] ?? NULL,
  //       'event_name2' => $inputs['event_name2'] ?? NULL,
  //       'event_owner' => $inputs['event_owner'] ?? NULL,
  //       'luggage_count' => $inputs['luggage_count'] ?? NULL,
  //       'luggage_arrive' => $inputs['luggage_arrive'] ?? NULL,
  //       'luggage_return' => $inputs['luggage_return'] ?? NULL,
  //       'email_flag' => 0,
  //       'in_charge' => '',
  //       'tel' => '',
  //       'cost' => !empty($inputs['cost']) ? $inputs['cost'] : 0,
  //       'discount_condition' => "",
  //       'attention' => "",
  //       'user_details' => null,
  //       'admin_details' => $inputs['admin_details'],
  //       'eat_in' => !empty($inputs['eat_in']) ? $inputs['eat_in'] : 0,
  //       'eat_in_prepare' => !empty($inputs['eat_in_prepare']) ? $inputs['eat_in_prepare'] : 0,
  //     ]);
  //     return $reservation;
  //   });
  //   return $reservation;
  // }

  public function UpdateAgentEndUser($inputs)
  {
    $this->enduser()->delete();
    if (
      !empty($inputs['enduser_company']) ||
      !empty($inputs['enduser_incharge']) ||
      !empty($inputs['enduser_address']) ||
      !empty($inputs['enduser_tel']) ||
      !empty($inputs['enduser_mail']) ||
      !empty($inputs['enduser_attr']) ||
      !empty($inputs['end_user_charge']) ||
      !empty($inputs['enduser_mobile'])
    ) {
      DB::transaction(function () use ($inputs) {
        $this->enduser()->create([
          'reservation_id' => $this->id,
          'company' => $inputs['enduser_company'],
          'person' => $inputs['enduser_incharge'],
          'address' => $inputs['enduser_address'],
          'tel' => $inputs['enduser_tel'],
          'email' => $inputs['enduser_mail'],
          'attr' => $inputs['enduser_attr'],
          'charge' => $inputs['end_user_charge'],
          'mobile' => $inputs['enduser_mobile'],
        ]);
      });
    }
  }

  public function totalAmountWithCxl()
  {
    $subtotal = $this->bills->where('reservation_status', '<=', 3)->pluck('master_total')->sum();
    $cxl = $this->cxls->pluck('master_total')->sum();
    return $subtotal + $cxl;
  }
}
