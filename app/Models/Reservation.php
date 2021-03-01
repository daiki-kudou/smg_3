<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Venue;
use App\Models\User;

use Carbon\Carbon;

use App\Traits\Search;


class Reservation extends Model
{
  use Search;

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
        'reservation_status' => 1, //デフォで1、仮押さえのデフォは0
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
          'unit_item' => "荷物預かり/返送",
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
      // レイアウト片付け
      if (!empty($value->layout_clean)) {
        $bills->breakdowns()->create([
          'unit_item' => "レイアウト片付料金",
          'unit_cost' => $layout_clean,
          'unit_count' => 1,
          'unit_subtotal' => $layout_clean,
          'unit_type' => 4,
        ]);
      }


      // toBreakDown($request->all(), 'venue_breakdown', $bills, 1);
      // toBreakDown($request->all(), 'equipment_breakdown', $bills, 2);
      // toBreakDown($request->all(), 'service_breakdown', $bills, 3);
      // toBreakDown($request->all(), 'others_breakdown', $bills, 5);
      // if ($request->luggage_subtotal) {
      //   $bills->breakdowns()->create([
      //     'unit_item' => $request->luggage_item,
      //     'unit_cost' => $request->luggage_cost,
      //     'unit_count' => 1,
      //     'unit_subtotal' => $request->luggage_subtotal,
      //     'unit_type' => 3,
      //   ]);
      // }
      // if ($request->layout_prepare_subtotal) {
      //   $bills->breakdowns()->create([
      //     'unit_item' => $request->layout_prepare_item,
      //     'unit_cost' => $request->layout_prepare_cost,
      //     'unit_count' => $request->layout_prepare_count,
      //     'unit_subtotal' => $request->layout_prepare_subtotal,
      //     'unit_type' => 4,
      //   ]);
      // }
      // if ($request->layout_clean_subtotal) {
      //   $bills->breakdowns()->create([
      //     'unit_item' => $request->layout_clean_item,
      //     'unit_cost' => $request->layout_clean_cost,
      //     'unit_count' => $request->layout_clean_count,
      //     'unit_subtotal' => $request->layout_clean_subtotal,
      //     'unit_type' => 4,
      //   ]);
      // }
      // if ($request->layout_breakdown_discount_item) {
      //   $bills->breakdowns()->create([
      //     'unit_item' => $request->layout_breakdown_discount_item,
      //     'unit_cost' => $request->layout_breakdown_discount_cost,
      //     'unit_count' => $request->layout_breakdown_discount_count,
      //     'unit_subtotal' => $request->layout_breakdown_discount_subtotal,
      //     'unit_type' => 4,
      //   ]);
      // }
    });
  }

  /*
|--------------------------------------------------------------------------
| 仲介会社選択の場合のみ、エンドユーザーとの一対一
|--------------------------------------------------------------------------|
*/
  public function enduser()
  {
    return $this->hasOne(Enduser::class);
  }

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
}
