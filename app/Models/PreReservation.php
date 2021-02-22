<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Venue;
use Illuminate\Support\Facades\DB; //トランザクション用


class PreReservation extends Model
{
  protected $fillable = [
    'multiple_reserve_id',
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
    'status',

  ];
  protected $dates = [
    'reserve_date',
    'payment_limit',
    'bill_created_at',
    'bill_pay_limit',
    'luggage_arrive'
  ];

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
| PreBillsとの一対多
|--------------------------------------------------------------------------|
*/
  public function pre_bill()
  {
    return $this->hasOne(PreBill::class);
  }
  /*
|--------------------------------------------------------------------------
| PreBillsを経由してbreakdowns
|--------------------------------------------------------------------------|
*/
  public function pre_breakdowns()
  {
    return $this->hasOneThrough(
      'App\Models\PreBreakdown',
      'App\Models\PreBill',
    );
  }


  /*
|--------------------------------------------------------------------------
| 一括IDとの連携
|--------------------------------------------------------------------------|
*/
  public function multiple_reserve()
  {
    return $this->belongsTo(MultipleReserve::class);
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

  // 未登録ユーザーとの１対１
  public function unknown_user()
  {
    // Profileモデルのデータを引っ張てくる
    return $this->hasOne(UnknownUser::class);
  }

  public function reCalculateVenue($requests, $venue_id)
  {
    $venue = Venue::find($venue_id);
    $venue_price_result = $venue->calculate_price(
      $requests->{'price_system_copied' . $requests->split_keys},
      $requests->{'enter_time' . $requests->split_keys},
      $requests->{'leave_time' . $requests->split_keys}
    );

    $s_equipment = [];
    $s_services = [];
    foreach ($requests->all() as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
      if (preg_match('/services_breakdown/', $key)) {
        $s_services[] = $value;
      }
    }

    $item_details = $venue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
    $layouts_details = $venue->getLayoutPrice(
      $requests->{'layout_prepare_copied' . $requests->split_keys},
      $requests->{'layout_clean_copied' . $requests->split_keys}
    );

    return [$venue_price_result, $item_details, $layouts_details];
  }

  public function specificUpdate($request, $result, $venue_id)
  {
    // echo "<pre>";
    // var_dump($request->all());
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($result);
    // echo "</pre>";

    $splitKey = $request->split_keys;

    DB::transaction(function () use ($request, $result, $venue_id, $splitKey) {
      $this->pre_breakdowns()->delete();
      $this->pre_bill()->delete();
      $this->update([
        'price_system' => $request->{'price_system_copied0' . $splitKey},
        'enter_time' => $request->{'enter_time' . $splitKey},
        'leave_time' => $request->{'leave_time' . $splitKey},
        'board_flag' => $request->{'board_flag_copied' . $splitKey},
        'event_start' => $request->{'event_start_copied' . $splitKey},
        'event_finish' => $request->{'event_finish_copied' . $splitKey},
        'event_name1' => $request->{'event_name1_copied' . $splitKey},
        'event_name2' => $request->{'event_name2_copied' . $splitKey},
        'event_owner' => $request->{'event_owner' . $splitKey},
        'luggage_count' => $request->{'luggage_count_copied' . $splitKey},
        'luggage_arrive' => $request->{'luggage_arrive_copied' . $splitKey},
        'luggage_return' => $request->{'luggage_return_copied' . $splitKey},
        'email_flag' => $request->{'email_flag_copied' . $splitKey},
        'in_charge' => $request->{'in_charge_copied' . $splitKey},
        'tel' => $request->{'tel_copied' . $splitKey},
        'discount_condition' => $request->{'discount_condition_copied' . $splitKey},
        'attention' => $request->{'attention_copied' . $splitKey},
        'admin_details' => $request->{'admin_details_copied' . $splitKey},
      ]);

      $venue_price = empty($result[0][2]) ? 0 : $result[0][2];
      var_dump($venue_price);
      echo "<br>";
      $equipment_price = empty($result[1][0]) ? 0 : $result[1][0];
      var_dump($equipment_price);
      echo "<br>";
      $layout_price = empty($result[2][2]) ? 0 : $result[2][2];
      var_dump($layout_price);
      echo "<br>";


      $master = $venue_price + $equipment_price + $layout_price;

      $pre_bill = $this->pre_bill()->create([
        'venue_price' => $venue_price,
        'equipment_price' => $equipment_price + ((int)$request->{'luggage_price_copied' . $splitKey}),
        'layout_price' => $layout_price,
        'others_price' => 0, //othersは後ほど
        'master_subtotal' => floor($master),
        'master_tax' => floor($master * 0.1),
        'master_total' => floor(($master) + ($master * 0.1)),
        'reservation_status' => 0,
        'category' => 1
      ]);

      if (!empty($result[0][1])) {
        $venue_prices = ['会場料金', $result[0][0], $result[0][3] - $result[0][4], $result[0][0]];
        $extend_prices = ['延長料金', $result[0][1], $result[0][4], $result[0][1]];
      } elseif (empty($result[0][0])) {
        $venue_prices = [];
        $extend_prices = [];
      } else {
        $venue_prices = ['会場料金', $result[0][0], $result[0][3] - $result[0][4], $result[0][0]];
        $extend_prices = [];
      }


      if ($venue_price != 0) {
        if ($extend_prices) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $venue_prices[0],
            'unit_cost' => $venue_prices[1],
            'unit_count' => $venue_prices[2],
            'unit_subtotal' => $venue_prices[3],
            'unit_type' => 1,
          ]);
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $extend_prices[0],
            'unit_cost' => $extend_prices[1],
            'unit_count' => $extend_prices[2],
            'unit_subtotal' => $extend_prices[3],
            'unit_type' => 1,
          ]);
        } else {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $venue_prices[0],
            'unit_cost' => $venue_prices[1],
            'unit_count' => $venue_prices[2],
            'unit_subtotal' => $venue_prices[3],
            'unit_type' => 1,
          ]);
        }
      }


      $equipments = $result[1][1];
      foreach ($equipments as $key => $equipment) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => $equipment[0],
          'unit_cost' => $equipment[1],
          'unit_count' => $equipment[2],
          'unit_subtotal' => $equipment[1] * $equipment[2],
          'unit_type' => 2,
        ]);
      }

      $services = ($result[1][2]);
      foreach ($services as $key => $service) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => $service[0],
          'unit_cost' => $service[1],
          'unit_count' => $service[2],
          'unit_subtotal' => $service[1] * $service[2],
          'unit_type' => 3,
        ]);
      }

      if ($request->{'luggage_price_copied' . $splitKey}) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => '荷物預かり/返送',
          'unit_cost' => $request->{'luggage_price_copied' . $splitKey},
          'unit_count' => 1,
          'unit_subtotal' => $request->{'luggage_price_copied' . $splitKey},
          'unit_type' => 3,
        ]);
      }

      $prepare = Venue::find($venue_id)->layout_prepare;
      if ($request->{'layout_prepare_copied' . $splitKey} == 1) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => 'レイアウト準備料金',
          'unit_cost' => $prepare,
          'unit_count' => 1,
          'unit_subtotal' => $prepare,
          'unit_type' => 4,
        ]);
      }

      $clean = Venue::find($venue_id)->layout_clean;
      if ($request->{'layout_clean_copied' . $splitKey} == 1) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => 'レイアウト片付料金',
          'unit_cost' => $clean,
          'unit_count' => 1,
          'unit_subtotal' => $clean,
          'unit_type' => 4,
        ]);
      }
    });
  }





  /*
|--------------------------------------------------------------------------
| 削除用
|--------------------------------------------------------------------------|
*/
  // Prebills 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->pre_bill()->get() as $child) {
        $child->delete();
      }
      foreach ($model->unknown_user()->get() as $child2) {
        $child2->delete();
      }
    });
  }
}
