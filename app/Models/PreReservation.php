<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Venue;
use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Reservation;
use App\Models\User;
use App\Models\Agent;

use Carbon\Carbon;

use Illuminate\Http\Request;


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
    'eat_in',
    'eat_in_prepare',
    'cost'

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


  // 仲介会社を利用した際のエンドユーザー
  public function pre_enduser()
  {
    return $this->hasOne(PreEndUser::class);
  }


  public function reCalculateVenue($requests, $venue_id)
  {
    $venue = Venue::with('frame_prices')->find($venue_id);
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
    $splitKey = $request->split_keys;
    DB::transaction(function () use ($request, $result, $venue_id, $splitKey) {
      $this->pre_breakdowns()->delete();
      $this->pre_bill()->delete();
      $this->update([
        'price_system' => $request->{'price_system_copied' . $splitKey},
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
        'cost' => $request->{'cost_copied' . $splitKey},
      ]);

      $venue_price = empty($result[0][2]) ? 0 : $result[0][2];

      $equipment_price = empty($result[1][0]) ? 0 : $result[1][0];

      $layout_price = empty($result[2][2]) ? 0 : $result[2][2];

      $luggage_price = $request->{'luggage_price_copied' . $splitKey};

      $master = $venue_price + $equipment_price + $layout_price + $luggage_price;

      $pre_bill = $this->pre_bill()->create([
        'venue_price' => $venue_price,
        'equipment_price' => $equipment_price + ((int) $request->{'luggage_price_copied' . $splitKey}),
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
          'unit_item' => '荷物預り/返送',
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


  public function AgentSpecificUpdate($request, $result, $venue_id, $pre_reservation_id)
  {
    $splitKey = $request->split_keys;
    DB::transaction(function () use ($request, $result, $venue_id, $splitKey, $pre_reservation_id) {
      $this->pre_breakdowns()->delete();
      $this->pre_bill()->delete();
      $this->update([
        'price_system' => $request->{'price_system_copied' . $splitKey},
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
        "eat_in" => $request->{'eat_in_copied' . $splitKey},
        "eat_in_prepare" => $request->{'eat_in_prepare_copied' . $splitKey},
        "cost" => $request->{'cost_copied' . $splitKey},
      ]);

      $this->pre_enduser()->update([
        'charge' => $request->{'enduser_charge_copied' . $splitKey},
      ]);

      $venue_price = 0;
      $equipment_price = 0;
      $layout_calc = Venue::find($venue_id);
      $layout_price = $layout_calc->getLayoutPrice($request->{'layout_prepare_copied' . $splitKey}, $request->{'layout_clean_copied' . $splitKey})[2];
      $luggage_price = 0;

      $master = $result + $layout_price;

      $pre_bill = $this->pre_bill()->create([
        'venue_price' => 0,
        'equipment_price' => 0,
        'layout_price' => $layout_price,
        'others_price' => 0, //othersは後ほど
        'master_subtotal' => floor($master),
        'master_tax' => floor($master * 0.1),
        'master_total' => floor(($master) + ($master * 0.1)),
        'reservation_status' => 0,
        'category' => 1
      ]);



      $carbon1 = new Carbon($this->enter_time);
      $carbon2 = new Carbon($this->leave_time);
      $usage_hours = $carbon1->diffInMinutes($carbon2);
      $usage_hours = $usage_hours / 60;

      $pre_bill->pre_breakdowns()->create([
        'unit_item' => "会場料金",
        'unit_cost' => 0,
        'unit_count' => $usage_hours,
        'unit_subtotal' => 0,
        'unit_type' => 1,
      ]);


      $equipments = Venue::find($venue_id);
      foreach ($equipments->equipments()->get() as $key => $equ) {
        if ($request->{'equipment_breakdown' . $key . '_copied' . $splitKey}) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $equ->item,
            'unit_cost' => 0,
            'unit_count' => $request->{'equipment_breakdown' . $key . '_copied' . $splitKey},
            'unit_subtotal' => 0,
            'unit_type' => 2,
          ]);
        }
      }

      $services = Venue::find($venue_id);
      foreach ($services->services()->get() as $key => $ser) {
        if ($request->{'services_breakdown' . $key . '_copied' . $splitKey} != 0) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $ser->item,
            'unit_cost' => 0,
            'unit_count' => $request->{'services_breakdown' . $key . '_copied' . $splitKey},
            'unit_subtotal' => 0,
            'unit_type' => 3,
          ]);
        }
      }

      if ($request->{'luggage_price_copied' . $splitKey}) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => '荷物預り/返送',
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


  public function AgentSingleStore($request, $agent, $venue)
  {
    DB::transaction(function () use ($request, $agent, $venue) {
      $pre_reservation = $this->create([
        'multiple_reserve_id' => 0,
        'venue_id' => $venue->id,
        'user_id' => 0,
        'agent_id' => $agent->id,
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
        'discount_condition' => '',
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        'status' => 0,
        'eat_in' => $request->eat_in,
        'eat_in_prepare' => $request->eat_in_prepare,
        'cost' => $request->cost,
      ]);
      $pre_bill = $pre_reservation->pre_bill()->create([
        'venue_price' => 0,
        'equipment_price' => 0,
        'layout_price' => $request->layouts_price ? $request->layouts_price : 0,
        'others_price' => 0,
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,
        'reservation_status' => 0,
        'approve_send_at' => NULL,
        'category' => 1
      ]);

      $venue_arrays = [];
      foreach ($request->all() as $v_key => $value) {
        if (preg_match("/venue_breakdown/", $v_key)) {
          $venue_arrays[] = $value;
        }
      }
      // 
      $judge_venue_arrays = array_filter($venue_arrays);
      if (!empty($judge_venue_arrays)) {
        for ($i = 0; $i < count($venue_arrays) / 2; $i++) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $venue_arrays[($i * 2)],
            'unit_cost' => 0,
            'unit_count' => $venue_arrays[($i * 2) + 1],
            'unit_subtotal' => 0,
            'unit_type' => 1,
          ]);
        }
      }

      $equ_arrays = [];
      foreach ($request->all() as $e_key => $value) {
        if (preg_match("/equipment_breakdown/", $e_key)) {
          $equ_arrays[] = $value;
        }
      }
      $judge_equ_arrays = array_filter($equ_arrays);
      if (!empty($judge_equ_arrays)) {
        for ($i = 0; $i < count($equ_arrays) / 2; $i++) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $equ_arrays[($i * 2)],
            'unit_cost' => 0,
            'unit_count' => $equ_arrays[($i * 2) + 1],
            'unit_subtotal' => 0,
            'unit_type' => 2,
          ]);
        }
      }
      $ser_arrays = [];
      foreach ($request->all() as $s_key => $value) {
        if (preg_match("/service_breakdown/", $s_key)) {
          $ser_arrays[] = $value;
        }
      }
      $judge_ser_arrays = array_filter($ser_arrays);
      if (!empty($judge_ser_arrays)) {
        for ($i = 0; $i < count($ser_arrays) / 2; $i++) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $ser_arrays[($i * 2)],
            'unit_cost' => 0,
            'unit_count' => $ser_arrays[($i * 2) + 1],
            'unit_subtotal' => 0,
            'unit_type' => 3,
          ]);
        }
      }
      if ($request->layout_prepare_item) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_prepare_subtotal,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_item) {
        $pre_bill->pre_breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_clean_subtotal,
          'unit_type' => 4,
        ]);
      }

      $oth_arrays = [];
      foreach ($request->all() as $o_key => $value) {
        if (preg_match("/others_input/", $o_key)) {
          $oth_arrays[] = $value;
        }
      }
      $judge_oth_arrays = array_filter($oth_arrays);
      if (!empty($judge_oth_arrays)) {
        for ($i = 0; $i < count($oth_arrays) / 2; $i++) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $oth_arrays[($i * 2)],
            'unit_cost' => 0,
            'unit_count' => $oth_arrays[($i * 2) + 1],
            'unit_subtotal' => 0,
            'unit_type' => 3,
          ]);
        }
      }
      $pre_reservation->pre_enduser()->create([
        "pre_reservation_id" => $pre_reservation->id,
        "company" => $request->pre_enduser_company,
        "person" => $request->pre_enduser_name,
        "email" => $request->pre_enduser_email,
        "mobile" => $request->pre_enduser_mobile,
        "tel" => $request->pre_enduser_tel,
        "address" => $request->pre_enduser_address,
        "attr" => $request->pre_enduser_attr,
        'charge' => $request->enduser_charge
      ]);
    });
  }

  public function Updates($request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      // breakdowns削除
      foreach ($this->pre_breakdowns()->get() as $key => $value) {
        $value->delete();
      }
      // pre bill削除
      $this->pre_bill()->delete();
      // 再作成
      $this->update([
        'user_id' => $request->user_id,
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
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        'status' => $request->status,
      ]);
    });
  }

  public function MoveToReservation(Request $request)
  {
    $this->user_id != 0 ? $user = User::find($this->user_id) : $user = 0;
    $this->agent_id != 0 ? $agent = Agent::find($this->agent_id) : $agent = 0;
    // 支払期日
    if (is_object($user)) $payment_limit = $user->getUserPayLimit($request->reserve_date);
    if (is_object($agent)) $payment_limit = $agent->getPayDetails($request->reserve_date);
    // bill company
    if (is_object($user)) $bill_company = $user->company;
    if (is_object($agent)) $bill_company = $agent->company;
    // bill person
    if (is_object($user)) $bill_person = $user->first_name . $user->last_name;
    if (is_object($agent)) $bill_person = $agent->person_firstname . $agent->person_lastname;

    $reservation = new Reservation();
    //reservationのReserveStoreに持たせるためのrequestを作成
    $request->merge([
      'venue_id' => $this->venue_id,
      'user_id' => $this->user_id,
      'agent_id' => 0, //デフォで0
      'reserve_date' => $this->reserve_date,
      'price_system' => $this->price_system,
      'enter_time' => $this->enter_time,
      'leave_time' => $this->leave_time,
      'board_flag' => $this->board_flag,
      'event_start' => $this->event_start,
      'event_finish' => $this->event_finish,
      'event_name1' => $this->event_name1,
      'event_name2' => $this->event_name2,
      'event_owner' => $this->event_owner,
      'luggage_count' => $this->luggage_count,
      'luggage_arrive' => $this->luggage_arrive,
      'luggage_return' => $this->luggage_return,
      'email_flag' => 0, //デフォで0(利用後の送信メール無し)を選択
      'in_charge' => $this->in_charge,
      'tel' => $this->tel,
      'cost' => $this->cost,
      'discount_condition' => $this->discount_condition,
      'attention' => $this->attention,
      'user_details' => $this->user_details,
      'admin_details' => $this->admin_details,
      'eat_in' => !empty($this->eat_in) ? $this->eat_in : 0,
      'eat_in_prepare' => !empty($this->eat_in_prepare) ? $this->eat_in_prepare : 0,
      "multiple_reserve_id" => $this->multiple_reserve_id,
    ]);
    //reservationのReserveStoreBillに持たせるためのrequestを作成
    $request->merge([
      'venue_price' => $this->pre_bill->venue_price,
      'equipment_price' => $this->pre_bill->equipment_price ? $this->pre_bill->equipment_price : 0, //備品・サービス・荷物
      'layout_price' => $this->pre_bill->layout_price ? $this->pre_bill->layout_price : 0,
      'others_price' => $this->pre_bill->others_price ? $this->pre_bill->others_price : 0,
      'master_subtotal' => $this->pre_bill->master_subtotal,
      'master_tax' => $this->pre_bill->master_tax,
      'master_total' => $this->pre_bill->master_total,
      'payment_limit' => $payment_limit,
      'bill_company' => $bill_company,
      'bill_person' => $bill_person,
      'bill_created_at' => Carbon::now(),
      'bill_remark' => '',
      'paid' => 0, //デフォで0、仮押さえから本予約切り替え時点では未入金のため
      'pay_day' => NULL,
      'pay_person' => '',
      'payment' => NULL,
      'reservation_status' => 1, //デフォで1、仮押えのデフォは0
      'double_check_status' => 0, //デフォで0
      'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
      'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
    ]);
    // breakdown保存用に、requestに現時点のpre_breakdownsの詳細を格納
    foreach ($this->pre_breakdowns()->where('unit_type', 1)->get() as $v_key => $v_breakdown) {
      $request->merge([
        'venue_breakdown_item' . $v_key => $v_breakdown->unit_item,
        'venue_breakdown_cost' . $v_key => $v_breakdown->unit_cost,
        'venue_breakdown_count' . $v_key => $v_breakdown->unit_count,
        'venue_breakdown_subtotal' . $v_key => $v_breakdown->unit_subtotal,
      ]);
    }
    foreach ($this->pre_breakdowns()->where('unit_type', 2)->get() as $e_key => $e_breakdown) {
      $request->merge([
        'equipment_breakdown_item' . $e_key => $e_breakdown->unit_item,
        'equipment_breakdown_cost' . $e_key => $e_breakdown->unit_cost,
        'equipment_breakdown_count' . $e_key => $e_breakdown->unit_count,
        'equipment_breakdown_subtotal' . $e_key => $e_breakdown->unit_subtotal,
      ]);
    }
    foreach ($this->pre_breakdowns()->where('unit_type', 3)->get() as $s_key => $s_breakdown) {
      $request->merge([
        'service_breakdown_item' . $s_key => $s_breakdown->unit_item,
        'service_breakdown_cost' . $s_key => $s_breakdown->unit_cost,
        'service_breakdown_count' . $s_key => $s_breakdown->unit_count,
        'service_breakdown_subtotal' . $s_key => $s_breakdown->unit_subtotal,
      ]);
    }
    foreach ($this->pre_breakdowns()->where('unit_type', 4)->get() as $l_key => $l_breakdown) {
      if ($l_breakdown->unit_item == 'レイアウト準備料金') {
        $request->merge([
          'layout_prepare_item' => $l_breakdown->unit_item,
          'layout_prepare_cost' => $l_breakdown->unit_cost,
          'layout_prepare_subtotal' => $l_breakdown->unit_subtotal,
        ]);
      }
      if ($l_breakdown->unit_item == 'レイアウト片付料金') {
        $request->merge([
          'layout_clean_item' => $l_breakdown->unit_item,
          'layout_clean_cost' => $l_breakdown->unit_cost,
          'layout_clean_subtotal' => $l_breakdown->unit_subtotal,
        ]);
      }
    }
    $reservation->ReserveStore($request);
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
