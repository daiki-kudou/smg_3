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
    'luggage_flag',
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
    return $this->belongsTo(User::class)->withTrashed();;
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

  public function PreReservationStore($data, $status = 0)
  {
    $result = $this->create([
      'multiple_reserve_id' => !empty($data['multiple_reserve_id']) ? $data['multiple_reserve_id'] : 0,
      'venue_id' => $data['venue_id'],
      'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
      'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
      'reserve_date' => $data['reserve_date'],
      'price_system' => $data['price_system'],
      'enter_time' => $data['enter_time'],
      'leave_time' => $data['leave_time'],
      'board_flag' => $data['board_flag'],
      'event_start' => $data['event_start'] ?? NULL,
      'event_finish' => $data['event_finish'] ?? NULL,
      'event_name1' => $data['event_name1'] ?? NULL,
      'event_name2' => $data['event_name2'] ?? NULL,
      'event_owner' => $data['event_owner'] ?? NULL,
      'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] :  0,
      'luggage_count' => $data['luggage_count'] ?? NULL,
      'luggage_arrive' => $data['luggage_arrive'] ?? NULL,
      'luggage_return' => $data['luggage_return'] ?? NULL,
      'email_flag' => $data['email_flag'],
      'in_charge' => $data['in_charge'],
      'tel' => $data['tel'],
      'discount_condition' => $data['discount_condition'] ?? NULL,
      'attention' => $data['attention'] ?? NULL,
      'user_details' => $data['user_details'] ?? NULL,
      'admin_details' => $data['admin_details'] ?? NULL,
      'status' => $status,
      'eat_in' => $data['eat_in'],
      'eat_in_prepare' => $data['eat_in_prepare'] ?? NULL,
      'cost' => $data['cost'] ?? 0,
    ]);
    return $result;
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
        'event_start' => $request->{'event_start_copied' . $splitKey} ?? NULL,
        'event_finish' => $request->{'event_finish_copied' . $splitKey} ?? NULL,
        'event_name1' => $request->{'event_name1_copied' . $splitKey} ?? NULL,
        'event_name2' => $request->{'event_name2_copied' . $splitKey} ?? NULL,
        'event_owner' => $request->{'event_owner' . $splitKey} ?? NULL,
        'luggage_count' => $request->{'luggage_count_copied' . $splitKey} ?? NULL,
        'luggage_arrive' => $request->{'luggage_arrive_copied' . $splitKey} ?? NULL,
        'luggage_return' => $request->{'luggage_return_copied' . $splitKey} ?? NULL,
        'email_flag' => $request->{'email_flag_copied' . $splitKey},
        'in_charge' => $request->{'in_charge_copied' . $splitKey},
        'tel' => $request->{'tel_copied' . $splitKey},
        'discount_condition' => $request->{'discount_condition_copied' . $splitKey},
        'attention' => $request->{'attention_copied' . $splitKey},
        'admin_details' => $request->{'admin_details_copied' . $splitKey},
        'cost' => $request->{'cost_copied' . $splitKey},
        "eat_in" => $request->{'eat_in_copied' . $splitKey},
        "eat_in_prepare" => $request->{'eat_in_prepare_copied' . $splitKey},

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
        'category' => 1,
        'end_user_charge' => 0
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
          'unit_item' => '荷物預かり',
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
        'event_start' => $request->{'event_start_copied' . $splitKey} ?? NULL,
        'event_finish' => $request->{'event_finish_copied' . $splitKey} ?? NULL,
        'event_name1' => $request->{'event_name1_copied' . $splitKey} ?? NULL,
        'event_name2' => $request->{'event_name2_copied' . $splitKey} ?? NULL,
        'event_owner' => $request->{'event_owner' . $splitKey} ?? NULL,
        'luggage_count' => $request->{'luggage_count_copied' . $splitKey} ?? NULL,
        'luggage_arrive' => $request->{'luggage_arrive_copied' . $splitKey} ?? NULL,
        'luggage_return' => $request->{'luggage_return_copied' . $splitKey} ?? NULL,
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
        'charge' => $request->{'end_user_charge_copied' . $splitKey},
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
        'category' => 1,
        'end_user_charge' => $request->end_user_charge_copied . $splitKey
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
          'unit_item' => '荷物預かり',
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
    $request_data = $request->all();
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
      foreach ($model->pre_enduser()->get() as $child3) {
        $child3->delete();
      }
    });
  }

  /**   
   * 予約一覧の検索対象マスタ
   * @return object collectionで返る
   */
  public function PreReservationSearchTarget()
  {
    $searchTarget = DB::table('pre_reservations')
      ->select(DB::raw(
        "
        LPAD(pre_reservations.id,6,0) as pre_reservation_id,
        pre_reservations.id as pre_reservation_id_original,
        concat(date_format(pre_reservations.created_at, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(pre_reservations.created_at) = 1 then '(日)' 
        when DAYOFWEEK(pre_reservations.created_at) = 2 then '(月)'
        when DAYOFWEEK(pre_reservations.created_at) = 3 then '(火)'
        when DAYOFWEEK(pre_reservations.created_at) = 4 then '(水)'
        when DAYOFWEEK(pre_reservations.created_at) = 5 then '(木)'
        when DAYOFWEEK(pre_reservations.created_at) = 6 then '(金)'
        when DAYOFWEEK(pre_reservations.created_at) = 7 then '(土)'
        end
        ) as created_at,
        concat(date_format(pre_reservations.reserve_date, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(pre_reservations.reserve_date) = 1 then '(日)' 
        when DAYOFWEEK(pre_reservations.reserve_date) = 2 then '(月)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 3 then '(火)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 4 then '(水)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 5 then '(木)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 6 then '(金)'
        when DAYOFWEEK(pre_reservations.reserve_date) = 7 then '(土)'
        end
        ) as reserve_date,
        time_format(pre_reservations.enter_time, '%H:%i') as enter_time,
        time_format(pre_reservations.leave_time, '%H:%i') as leave_time,
        concat(venues.name_area, venues.name_bldg, venues.name_venue) as venue_name,
        venues.id,
        users.company as company,
        concat(users.first_name, users.last_name) as person_name,
        users.mobile as mobile,
        users.tel as tel,
        unknown_users.unknown_user_company as unknownuser,
        agents.name as agent_name,
        pre_endusers.company as enduser,
        pre_reservations.status as pre_reservation_status,
      case when pre_bills.reservation_status <= 3 then 0 else 1 end as 予約中かキャンセルか,
      case when pre_reservations.reserve_date >= CURRENT_DATE then 0 else 1 end as 今日以降かどうか,
      case when pre_reservations.reserve_date >= CURRENT_DATE then reserve_date end as 今日以降日付,
      case when pre_reservations.reserve_date < CURRENT_DATE then reserve_date end as 今日未満日付
        "
      ))
      ->leftJoin('venues', 'pre_reservations.venue_id', '=', 'venues.id')
      ->leftJoin('users', 'pre_reservations.user_id', '=', 'users.id')
      ->leftJoin('unknown_users', 'pre_reservations.id', '=', 'unknown_users.pre_reservation_id')
      ->leftJoin('agents', 'pre_reservations.agent_id', '=', 'agents.id')
      ->leftJoin('pre_endusers', 'pre_reservations.id', '=', 'pre_endusers.pre_reservation_id')
      ->leftJoin('pre_bills', 'pre_reservations.id', '=', 'pre_bills.pre_reservation_id')
      ->whereRaw('pre_reservations.multiple_reserve_id = ?', [0]);


    return $searchTarget;
  }

  public function SearchPreReservation($data)
  {
    $searchTarget = $this->PreReservationSearchTarget();

    if (!empty($data['search_id']) && (int)$data['search_id'] > 0) {
      $searchTarget->whereRaw('pre_reservations.id LIKE ? ',  ['%' . $data['search_id'] . '%']);
    }

    if (!empty($data['search_created_at'])) {
      $targetData = explode(" ~ ", $data['search_created_at']);
      $targetData[0] = $targetData[0] . ' 00:00:00';
      $targetData[1] = $targetData[1] . ' 23:59:59';
      $searchTarget->whereRaw('pre_reservations.created_at between ? AND ? ',  $targetData);
    }

    if (!empty($data['search_date'])) {
      $targetData = explode(" ~ ", $data['search_date']);
      $targetData[0] = $targetData[0] . ' 00:00:00';
      $targetData[1] = $targetData[1] . ' 23:59:59';
      $searchTarget->whereRaw('pre_reservations.reserve_date between ? AND ? ',  $targetData);
    }

    if (!empty($data['search_venue']) && (int)$data['search_venue'] !== 0) {
      $searchTarget->whereRaw('venues.id = ? ',  [(int)$data['search_venue']]);
    }

    if (!empty($data['search_company'])) {
      $searchTarget->whereRaw('users.company LIKE ? ',  ['%' . $data['search_company'] . '%']);
    }

    if (!empty($data['search_person'])) {
      $searchTarget->whereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['search_person'] . '%']);
    }

    if (!empty($data['search_mobile'])) {
      $searchTarget->whereRaw('users.mobile LIKE ? ',  ['%' . $data['search_mobile'] . '%']);
    }

    if (!empty($data['search_tel'])) {
      $searchTarget->whereRaw('users.tel LIKE ? ',  ['%' . $data['search_tel'] . '%']);
    }

    if (!empty($data['search_unkown_user'])) {
      $searchTarget->whereRaw('unknown_users.unknown_user_company LIKE ? ',  ['%' . $data['search_unkown_user'] . '%']);
    }

    if (!empty($data['search_agent']) && (int)$data['search_agent'] !== 0) {
      $searchTarget->whereRaw('agents.id = ? ',  [(int)$data['search_agent']]);
    }

    if (!empty($data['search_end_user'])) {
      $searchTarget->whereRaw('pre_endusers.company LIKE ? ',  ['%' . $data['search_end_user'] . '%']);
    }

    if (!empty($data['time_over']) && (int)$data['time_over'] === 1) {
      $searchTarget->whereRaw('pre_reservations.status = ? and pre_reservations.updated_at < DATE_SUB(CURRENT_DATE(),INTERVAL ? DAY) ', [1, 3]);
    }

    return $searchTarget;
  }
}
