<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Venue;
use App\Models\User;
use App\Models\Cxl;
use App\Models\Enduser;

use Carbon\Carbon;

use App\Presenters\ReservationPresenter;
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Traits\InvoiceTrait;


class Reservation extends Model implements PresentableInterface
{
  use InvoiceTrait;

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
    'eat_in',
    'eat_in_prepare',
    'multiple_reserve_id'
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
  /*
|--------------------------------------------------------------------------
| 管理者　予約　保存
|--------------------------------------------------------------------------|
*/
  // session利用
  public function ReserveStoreSession($request, $sessionName, $sessionName2)
  {
    $master_info = $request->session()->get($sessionName);
    $reservation = DB::transaction(function () use ($master_info, $request, $sessionName2) { //トランザクションさせる
      $reservation = $this->create([
        'venue_id' => $master_info['venue_id'],
        'user_id' => $master_info['user_id'],
        'agent_id' => 0, //デフォで0
        'reserve_date' => $master_info['reserve_date'],
        'price_system' => $master_info['price_system'],
        'enter_time' => $master_info['enter_time'],
        'leave_time' => $master_info['leave_time'],
        'board_flag' => $master_info['board_flag'],
        'event_start' => !empty($master_info['event_start']) ? $master_info['event_start'] : null,
        'event_finish' => !empty($master_info['event_finish']) ? $master_info['event_finish'] : null,
        'event_name1' => !empty($master_info['event_name1']) ? $master_info['event_name1'] : null,
        'event_name2' => !empty($master_info['event_name2']) ? $master_info['event_name2'] : null,
        'event_owner' => !empty($master_info['event_owner']) ? $master_info['event_owner'] : null,
        'luggage_count' => !empty($master_info['luggage_count']) ? $master_info['luggage_count'] : null,
        'luggage_arrive' => !empty($master_info['luggage_arrive']) ? $master_info['luggage_arrive'] : null,
        'luggage_return' => !empty($master_info['luggage_return']) ? $master_info['luggage_return'] : null,
        'email_flag' => $master_info['email_flag'],
        'in_charge' => $master_info['in_charge'],
        'tel' => $master_info['tel'],
        'cost' => !empty($master_info['cost']) ? $master_info['cost'] : 0,
        'discount_condition' => "",
        'attention' => "",
        'user_details' => $master_info['user_details'],
        'admin_details' => $master_info['admin_details'],
        'eat_in' => !empty($master_info['eat_in']) ? $master_info['eat_in'] : 0,
        'eat_in_prepare' => !empty($master_info['eat_in_prepare']) ? $master_info['eat_in_prepare'] : 0,
      ]);
      // $reservation->ReserveStoreSessionBill($request, $sessionName2, $sessionName2);
      return $reservation;
    });
    return $reservation;
  }
  // session利用
  public function ReserveStoreSessionBill($request, $sessionName, $sessionName2, $attr = "normal")
  {
    $discount_info = $request->session()->get($sessionName);
    if ($attr == "add") {
      $venue_price = !empty($discount_info['venue_price']) ? $discount_info['venue_price'] : 0;
      $category = 2;
    } else {
      $venue_price = $discount_info['venue_price'];
      $category = 1;
    }
    // 以下、請求書No作成用
    $bill = DB::transaction(function () use ($discount_info, $request, $sessionName2, $attr, $venue_price, $category) {
      $bill = $this->bills()->create([
        'reservation_id' => $this->id,
        'venue_price' => $venue_price,
        'equipment_price' => !empty($discount_info['equipment_price']) ? $discount_info['equipment_price'] : 0, //備品・サービス・荷物
        'layout_price' => !empty($discount_info['layout_price']) ? $discount_info['layout_price'] : 0,
        'others_price' => !empty($discount_info['others_price']) ? $discount_info['others_price'] : 0,
        'master_subtotal' => $discount_info['master_subtotal'],
        'master_tax' => $discount_info['master_tax'],
        'master_total' => $discount_info['master_total'],
        'payment_limit' => $discount_info['pay_limit'],
        'bill_company' => $discount_info['pay_company'],
        'bill_person' => $discount_info['bill_person'],
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $discount_info['bill_remark'],
        'paid' => $discount_info['paid'],
        'pay_day' => $discount_info['pay_day'],
        'pay_person' => $discount_info['pay_person'],
        'payment' => $discount_info['payment'],
        'reservation_status' => 1, //デフォで1、仮押えのデフォは0
        'double_check_status' => 0, //デフォで0
        'category' => $category, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
        'invoice_number' => $this->generate_invoice_number(),
      ]);
      // $bill->ReserveStoreSessionBreakdown($request, $sessionName2);
      return $bill;
    });
    return $bill;
  }

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
        'cost' => !empty($request->cost) ? $request->cost : 0,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        'eat_in' => !empty($request->eat_in) ? $request->eat_in : 0,
        'eat_in_prepare' => !empty($request->eat_in_prepare) ? $request->eat_in_prepare : 0,
        'multiple_reserve_id' => ($request->multiple_reserve_id)
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
        'invoice_number' => $this->generate_invoice_number(),

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
        'eat_in' => !empty($value->eat_in) ? $value->eat_in : 0,
        'eat_in_prepare' => !empty($value->eat_in_prepare) ? $value->eat_in_prepare : 0,
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
        'invoice_number' => $this->generate_invoice_number(),
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
        'cost' => !empty($request->cost) ? $request->cost : 0,
        'eat_in' => !empty($request->eat_in) ? $request->eat_in : 0,
        'eat_in_prepare' => !empty($request->eat_in_prepare) ? $request->eat_in_prepare : 0,
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
        'invoice_number' => $this->generate_invoice_number(),
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
    $class = $this->where(function ($query) use ($request) {

      if ($request->search_id) {
        $editId = $request->search_id;
        if (substr($request->search_id, 0, 5) == "00000") {
          $editId = str_replace("00000", "", $request->search_id);
        } elseif (substr($request->search_id, 0, 4) == "0000") {
          $editId = str_replace("0000", "", $request->search_id);
        } elseif (substr($request->search_id, 0, 3) == "000") {
          $editId = str_replace("000", "", $request->search_id);
        } elseif (substr($request->search_id, 0, 2) == "00") {
          $editId = str_replace("00", "", $request->search_id);
        }
        $query->where("id", "LIKE", "%" . $editId . "%");
      }

      if ($request->reserve_date) {
        $query->whereDate("reserve_date", $request->reserve_date);
      }

      if ($request->enter_time) {
        $query->whereTime("enter_time", '>=', $request->enter_time);
      }

      if ($request->leave_time) {
        $query->whereTime("leave_time", '<=', $request->leave_time);
      }

      if ($request->venue_id) {
        $query->where("venue_id",  $request->venue_id);
      }

      if ($request->company) {
        $query->whereHas('user', function ($query) use ($request) {
          $query->where('company', 'LIKE', "%{$request->company}%");
        })->orWhereHas('agent', function ($query) use ($request) {
          $query->where('company', 'LIKE', "%{$request->company}%");
        });
      }

      if ($request->person_name) {
        $query->whereHas('user', function ($query) use ($request) {
          $query->where('first_name', 'LIKE', "%{$request->person_name}%");
          $query->orWhere('last_name', 'LIKE', "%{$request->person_name}%");
          $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->person_name . '%');
        })->orWhereHas('agent', function ($query) use ($request) {
          $query->where('person_firstname', 'LIKE', "%{$request->person_name}%");
          $query->orWhere('person_lastname', 'LIKE', "%{$request->person_name}%");
          $query->orWhere(DB::raw('CONCAT(person_firstname, person_lastname)'), 'like', '%' . $request->person_name . '%');
        });
      }

      if ($request->search_mobile) {
        $query->whereHas('user', function ($query) use ($request) {
          $query->where('mobile', 'LIKE', "%{$request->search_mobile}%");
        })->orWhereHas('agent', function ($query) use ($request) {
          $query->where('person_mobile', 'LIKE', "%{$request->search_mobile}%");
        });
      }

      if ($request->search_tel) {
        $query->whereHas('user', function ($query) use ($request) {
          $query->where('tel', 'LIKE', "%{$request->search_tel}%");
        })->orWhereHas('agent', function ($query) use ($request) {
          $query->where('person_tel', 'LIKE', "%{$request->search_tel}%");
        });
      }

      if ($request->agent) {
        $query->where("agent_id",  $request->agent);
      }

      if ($request->enduser_person) {
        $query->whereHas('enduser', function ($query) use ($request) {
          $query->where('company', 'LIKE', "%{$request->enduser_person}%");
        });
      }

      // アイコン（備品。サービス、レイアウト、ケータリング検索）
      $query->where(function ($query) use ($request) {
        for ($i = 1; $i <= 4; $i++) {
          if (!empty($request->{"check_icon" . $i})) {
            $query->orWhereHas('breakdowns', function ($query) use ($request, $i) {
              $query->where('unit_type', $request->{'check_icon' . $i});
            });
          }
        }
      });

      // 予約状況検索
      $query->where(function ($query) use ($request) {
        for ($i = 1; $i <= 6; $i++) {
          if (!empty($request->{"check_status" . $i})) {
            $query->orWhereHas('bills', function ($query) use ($request, $i) {
              $query->where('reservation_status', $request->{'check_status' . $i});
            });
          }
        }
      });

      if ($request->freeword) {
        $query->where('id', 'LIKE', "%{$request->freeword}%")
          ->orWhere("company", "LIKE", "%{$request->freeword}%")
          ->orWhere("first_name", "LIKE", "%{$request->freeword}%")
          ->orWhere("last_name", "LIKE", "%{$request->freeword}%")
          ->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->freeword . '%')
          ->orWhere("mobile", "LIKE", "%{$request->freeword}%")
          ->orWhere("tel", "LIKE", "%{$request->freeword}%")
          ->orWhere("email", "LIKE", "%{$request->freeword}%");
      }

      // 前日予約
      if ($request->day_before) {
        $today = Carbon::now();
        $yesterday = $today->subDay();
        $query->whereDate('reserve_date', date('Y-m-d', strtotime($yesterday)));
      }
      // 当日予約
      if ($request->today) {
        $today = Carbon::now();
        $query->whereDate('reserve_date', date('Y-m-d', strtotime($today)));
      }
      // 翌日予約
      if ($request->day_after) {
        $tomorrow = Carbon::tomorrow();
        $query->whereDate('reserve_date', date('Y-m-d', strtotime($tomorrow)));
      }
    });

    return $class;
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
  public function UpdateReservation($basicInfo, $result)
  {
    DB::transaction(function () use ($basicInfo, $result) {
      $this->update([
        'user_id' => $basicInfo['user_id'],
        'agent_id' => 0, //デフォで0
        'price_system' => $basicInfo['price_system'],
        'enter_time' => $basicInfo['enter_time'],
        'leave_time' => $basicInfo['leave_time'],
        'board_flag' => $basicInfo['board_flag'],
        'event_start' => $basicInfo['event_start'],
        'event_finish' => $basicInfo['event_finish'],
        'event_name1' => $basicInfo['event_name1'],
        'event_name2' => $basicInfo['event_name2'],
        'event_owner' => $basicInfo['event_owner'],
        'luggage_count' => $basicInfo['luggage_count'],
        'luggage_arrive' => $basicInfo['luggage_arrive'],
        'luggage_return' => $basicInfo['luggage_return'],
        'email_flag' => $basicInfo['email_flag'],
        'in_charge' => $basicInfo['in_charge'],
        'tel' => $basicInfo['tel'],
        'cost' => !empty($basicInfo['cost']) ? $basicInfo['cost'] : 0,
        'admin_details' => $basicInfo['admin_details'],
        'eat_in' => !empty($basicInfo['eat_in']) ? $basicInfo['eat_in'] : 0,
        'eat_in_prepare' => !empty($basicInfo['eat_in_prepare']) ? $basicInfo['eat_in_prepare'] : 0,
      ]);
    });
  }

  public function checkBillsStatus()
  {
    $collection = $this->bills->pluck('reservation_status');
    foreach ($collection as $key => $value) {
      if ($value < 3) {
        //ステータスが予約完了　もしくは　キャンセル完了していないキャンセルプロセスがあれば
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
        //ステータスが予約完了　もしくは　キャンセル完了していないキャンセルプロセスがあれば
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

  public function updateAgentReservation($inputs)
  {
    $reservation = DB::transaction(function () use ($inputs) { //トランザクションさせる
      $reservation = $this->update([
        'agent_id' => $inputs['agent_id'],
        'price_system' => $inputs['price_system'],
        'enter_time' => $inputs['enter_time'],
        'leave_time' => $inputs['leave_time'],
        'board_flag' => $inputs['board_flag'],
        'event_start' => !empty($inputs['event_start']) ? $inputs['event_start'] : "",
        'event_finish' => !empty($inputs['event_finish']) ? $inputs['event_finish'] : "",
        'event_name1' => !empty($inputs['event_name1']) ? $inputs['event_name1'] : "",
        'event_name2' => !empty($inputs['event_name2']) ? $inputs['event_name2'] : "",
        'event_owner' => !empty($inputs['event_owner']) ? $inputs['event_owner'] : "",
        'luggage_count' => $inputs['luggage_count'],
        'luggage_arrive' => $inputs['luggage_arrive'],
        'luggage_return' => $inputs['luggage_return'],
        'email_flag' => 0,
        'in_charge' => '',
        'tel' => '',
        'cost' => !empty($inputs['cost']) ? $inputs['cost'] : 0,
        'discount_condition' => "",
        'attention' => "",
        'user_details' => null,
        'admin_details' => $inputs['admin_details'],
        'eat_in' => !empty($inputs['eat_in']) ? $inputs['eat_in'] : 0,
        'eat_in_prepare' => !empty($inputs['eat_in_prepare']) ? $inputs['eat_in_prepare'] : 0,
      ]);
      return $reservation;
    });
    return $reservation;
  }

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
      !empty($inputs['enduser_charge']) ||
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
          'charge' => $inputs['enduser_charge'],
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
