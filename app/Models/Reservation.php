<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Venue;
use App\Models\User;

use Carbon\Carbon;



class Reservation extends Model
{

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
    'luggage_count',
    'luggage_arrive',
    'luggage_return',
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
    return $this->belongsTo(User::class);
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
  /*
|--------------------------------------------------------------------------
| 管理者　予約　保存
|--------------------------------------------------------------------------|
*/
  public function ReserveStore($request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation = $this->create([
        'venue_id' => $request->venue_id,
        'user_id' => $request->user_id,
        'agent_id' => 0, //デフォで0
        'reserve_date' => $request->reserve_date,
        'price_system' => $request->price_system,
        'enter_time' => $request->enter_time,
        'leave_time' => $request->leave_time,
        'board_flag' => $request->board_flag,
        'event_start' => $request->event_start,
        'event_finish' => $request->event_finish,
        'event_name1' => $request->event_name1,
        'event_name2' => $request->event_name2,
        'event_owner' => $request->event_owner,
        'luggage_count' => $request->luggage_count,
        'luggage_arrive' => $request->luggage_arrive,
        'luggage_return' => $request->luggage_return,
        'email_flag' => $request->email_flag,
        'in_charge' => $request->in_charge,
        'tel' => $request->tel,
        'cost' => $request->cost,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
      ]);
      $reservation->ReserveStoreBill($request);
    });
  }

  public function ReserveStoreBill($request)
  {
    DB::transaction(function () use ($request) {
      $bill = $this->bills()->create([
        'reservation_id' => $this->id,
        'venue_price' => $request->venue_price,
        'equipment_price' => $request->equipment_price ? $request->equipment_price : 0, //備品・サービス・荷物
        'layout_price' => $request->layout_price ? $request->layout_price : 0,
        'others_price' => $request->others_price ? $request->others_price : 0,
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
        'reservation_status' => 1, //デフォで1、仮押えのデフォは0
        'double_check_status' => 0, //デフォで0
        'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
      ]);
      $bill->ReserveStoreBreakdown($request);
    });
  }




  /*
|--------------------------------------------------------------------------
| ユーザーからの予約
|--------------------------------------------------------------------------|
*/
  public function ReserveFromUser($value, $user)
  {
    $venue = Venue::find($value->venue_id);
    $s_user = User::find($user);
    $payment_limit = $s_user->getUserPayLimit($value->date);
    DB::transaction(function () use ($value, $user, $s_user, $venue, $payment_limit) {
      $reservation = $this->create([
        'venue_id' => $value->venue_id,
        'user_id' => $user,
        'agent_id' => 0, //デフォで0
        'reserve_date' => $value->date,
        'price_system' => $value->price_system,
        'enter_time' => $value->enter_time,
        'leave_time' => $value->leave_time,
        'board_flag' => $value->board_flag,
        'event_start' => $value->event_start,
        'event_finish' => $value->event_finish,
        'event_name1' => $value->event_name1,
        'event_name2' => $value->event_name2,
        'event_owner' => $value->event_owner,
        'luggage_count' => $value->luggage_count,
        'luggage_arrive' => $value->luggage_arrive,
        'luggage_return' => $value->luggage_return,
        'email_flag' => 0,
        'in_charge' => $value->in_charge,
        'tel' => $value->tel,
        'cost' => 0,
        'discount_condition' => "",
        'attention' => "",
        'user_details' => "",
        'admin_details' => "",
      ]);

      $layout_prepare = !empty($value->layout_prepare) ? $venue->layout_prepare : 0;
      $layout_clean = !empty($value->layout_clean) ? $venue->layout_clean : 0;
      $layout_sum = $layout_prepare + $layout_clean;
      $bills = $reservation->bills()->create([
        'reservation_id' => $reservation->id,
        'venue_price' => json_decode($value->price_result)[0],
        'equipment_price' => json_decode($value->items_results)[0] ? json_decode($value->items_results)[0] : 0, //備品・サービス・荷物
        'layout_price' => $layout_sum,
        'others_price' => 0,
        // 該当billの合計額関連
        'master_subtotal' => $value->master,
        'master_tax' => floor($value->master * 0.1),
        'master_total' => floor(($value->master * 0.1) + $value->master),

        'payment_limit' => $payment_limit,
        'bill_company' => $s_user->getCompany(),
        'bill_person' => $s_user->getPerson(),
        'bill_created_at' => Carbon::now(),
        'bill_remark' => "",
        'paid' => 0,
        'reservation_status' => 1, //デフォで1、仮押えのデフォは0
        'double_check_status' => 0, //デフォで0
        'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        'admin_judge' => 2, //管理者作成なら1 ユーザー作成なら2
      ]);

      // 料金内訳
      if (json_decode($value->price_result)[1] == 0) {
        $bills->breakdowns()->create([
          'unit_item' => "会場料金",
          'unit_cost' => json_decode($value->price_result)[0],
          'unit_count' => json_decode($value->price_result)[3] - json_decode($value->price_result)[4],
          'unit_subtotal' => json_decode($value->price_result)[0],
          'unit_type' => 1,
        ]);
      } else {
        $bills->breakdowns()->create([
          'unit_item' => "会場料金",
          'unit_cost' => json_decode($value->price_result)[0],
          'unit_count' => json_decode($value->price_result)[3] - json_decode($value->price_result)[4],
          'unit_subtotal' => json_decode($value->price_result)[0],
          'unit_type' => 1,
        ]);
        $bills->breakdowns()->create([
          'unit_item' => "延長料金",
          'unit_cost' => json_decode($value->price_result)[1],
          'unit_count' => json_decode($value->price_result)[4],
          'unit_subtotal' => json_decode($value->price_result)[1],
          'unit_type' => 1,
        ]);
      }

      // 備品
      foreach (json_decode($value->items_results)[1] as $e_key => $equ) {
        $bills->breakdowns()->create([
          'unit_item' => $equ[0],
          'unit_cost' => $equ[1],
          'unit_count' => $equ[2],
          'unit_subtotal' => $equ[1] * $equ[2],
          'unit_type' => 2,
        ]);
      }
      // サービス
      foreach (json_decode($value->items_results)[2] as $s_key => $ser) {
        $bills->breakdowns()->create([
          'unit_item' => $ser[0],
          'unit_cost' => $ser[1],
          'unit_count' => 1,
          'unit_subtotal' => $ser[1],
          'unit_type' => 3,
        ]);
      }
      // 荷物
      if (!empty($value->luggage_count) || !empty($value->luggage_arrive) || !empty($value->luggage_return)) {
        $bills->breakdowns()->create([
          'unit_item' => "荷物預り/返送",
          'unit_cost' => 500,
          'unit_count' => 3,
          'unit_subtotal' => 500,
          'unit_type' => 3,
        ]);
      }
      // レイアウト準備
      if (!empty($value->layout_prepare)) {
        $bills->breakdowns()->create([
          'unit_item' => "レイアウト準備料金",
          'unit_cost' => $layout_prepare,
          'unit_count' => 1,
          'unit_subtotal' => $layout_prepare,
          'unit_type' => 4,
        ]);
      }
      // 片付
      if (!empty($value->layout_clean)) {
        $bills->breakdowns()->create([
          'unit_item' => "レイアウト片付料金",
          'unit_cost' => $layout_clean,
          'unit_count' => 1,
          'unit_subtotal' => $layout_clean,
          'unit_type' => 4,
        ]);
      }
    });
  }

  // 仲介会社からの予約
  public function ReserveFromAgent($request)
  {
    DB::transaction(function () use ($request) {
      $reservation = $this->create([
        'venue_id' => $request->venue_id,
        'user_id' => 0, //デフォで0
        'agent_id' => $request->agent_id,
        'reserve_date' => $request->reserve_date,
        'price_system' => $request->price_system,
        'enter_time' => $request->enter_time,
        'leave_time' => $request->leave_time,
        'board_flag' => $request->board_flag,
        'event_start' => $request->event_start,
        'event_finish' => $request->event_finish,
        'event_name1' => $request->event_name1,
        'event_name2' => $request->event_name2,
        'event_owner' => $request->event_owner,
        'luggage_count' => $request->luggage_count,
        'luggage_arrive' => $request->luggage_arrive,
        'luggage_return' => $request->luggage_return,
        'email_flag' => 0,
        'in_charge' => '',
        'tel' => '',
        'cost' => 0,
        'admin_details' => $request->admin_details,
      ]);
      $reservation->CreateEndUser($request);
      $reservation->ReserveFromAgentBill($request);
    });
  }

  public function CreateEndUser($request)
  {
    if (
      !empty($request->enduser_company) ||
      !empty($request->enduser_incharge) ||
      !empty($request->enduser_address) ||
      !empty($request->enduser_tel) ||
      !empty($request->enduser_mail) ||
      !empty($request->enduser_attr) ||
      !empty($request->enduser_charge) ||
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
          'charge' => $request->enduser_charge,
          'mobile' => $request->enduser_mobile,
        ]);
      });
    }
  }

  public function ReserveFromAgentBill($request)
  {
    DB::transaction(function () use ($request) {
      $bill = $this->bills()->create([
        'reservation_id' => $this->id,
        'venue_price' => 0, //デフォで0
        'equipment_price' => 0, //デフォで0
        'layout_price' =>  $request->layouts_price ? $request->layouts_price : 0, //デフォで0
        'others_price' => 0, //デフォで0
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,
        'payment_limit' => $request->pay_limit,
        'bill_company' => $request->pay_company,
        'bill_person' => $request->bill_person,
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $request->bill_remark,
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => $request->payment,
        'reservation_status' => 1, //デフォで1、仮押えのデフォは0
        'double_check_status' => 0, //デフォで0
        'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
      ]);
      $bill->ReserveFromAgentBreakdown($request);
    });
  }


  // 仲介会社選択の場合のみ、エンドユーザーとの一対一

  public function enduser()
  {
    return $this->hasOne(Enduser::class);
  }


  // 検索マスタ

  public function search_item($request)
  {
    $query = $this->query();
    if (!empty($request->id)) {
      $query->where('id', $request->id)->get();
    }

    if (!empty($request->reserve_date)) {
      $query->where('reserve_date', $request->reserve_date)->get();
    }

    // return ($query);
    return $query->paginate(10);

    // ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
    // 検索の雛形はこれでOK
    // ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
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
    foreach ($this->bills()->get() as $key => $value) {
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
  public function UpdateReservation($request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $this->update([
        'venue_id' => $request->venue_id,
        'user_id' => $request->user_id,
        'agent_id' => 0, //デフォで0
        'reserve_date' => $request->reserve_date,
        'price_system' => $request->price_system,
        'enter_time' => $request->enter_time,
        'leave_time' => $request->leave_time,
        'board_flag' => $request->board_flag,
        'event_start' => $request->event_start,
        'event_finish' => $request->event_finish,
        'event_name1' => $request->event_name1,
        'event_name2' => $request->event_name2,
        'event_owner' => $request->event_owner,
        'luggage_count' => $request->luggage_count,
        'luggage_arrive' => $request->luggage_arrive,
        'luggage_return' => $request->luggage_return,
        'email_flag' => $request->email_flag,
        'in_charge' => $request->in_charge,
        'tel' => $request->tel,
        'cost' => $request->cost,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
      ]);
      $this->bills()->first()->UpdateBill($request);
      $this->bills()->first()->ReserveStoreBreakdown($request);
      $request->session()->regenerate();
      return redirect()->route('admin.reservations.index');
    });
  }
}
