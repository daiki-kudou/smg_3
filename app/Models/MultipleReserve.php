<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Presenters\MultipleReservePresenter; //個別作成したプレゼンターの追加
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Models\Venue;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use Illuminate\Support\Facades\DB; //トランザクション用

use Carbon\Carbon;

class MultipleReserve extends Model implements PresentableInterface //プレゼンタをインプリメント
{

  /**
   * Return a created presenter.
   *
   * @return Robbo\Presenter\Presenter
   */
  public function getPresenter() //実装したプレゼンタを利用
  {
    return new MultipleReservePresenter($this);
  }

  /*
|--------------------------------------------------------------------------
| pre reservation 一対多
|--------------------------------------------------------------------------|
*/
  public function pre_reservations()
  {
    return $this->hasMany(PreReservation::class);
  }

  public function calculateVenue($venue_id, $all_requests)
  {
    $venue = Venue::with('frame_prices')->find($venue_id);
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->orderBy('id')->get();

    $venue_price_result = []; //予約の個数分の会場の料金
    foreach ($pre_reservations as $key => $pre_reservation) {
      $venue_price = $venue->calculate_price(
        $all_requests->cp_master_price_system,
        $pre_reservation->enter_time,
        $pre_reservation->leave_time
      );
      $venue_price_result[] = $venue_price;
    }

    $s_equipment = [];
    $s_services = [];
    foreach ($all_requests->all() as $key => $value) {
      if (preg_match('/cp_master_equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
      if (preg_match('/cp_master_services_breakdown/', $key)) {
        $s_services[] = $value;
      }
    }

    $item_details = $venue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
    $layouts_details = $venue->getLayoutPrice($all_requests->cp_master_layout_prepare, $all_requests->cp_master_layout_clean);

    return [$venue_price_result, $item_details, $layouts_details];
  }


  public function preStore($venue_id, $requests, $result)
  {
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->orderBy('id')->get();

    DB::transaction(function () use ($venue_id, $requests, $result, $pre_reservations) {
      foreach ($pre_reservations as $key => $pre_reservation) {
        $pre_reservation->update([
          'price_system' => $requests->cp_master_price_system,
          'board_flag' => $requests->cp_master_board_flag,
          'event_start' => $requests->cp_master_event_start,
          'event_finish' => $requests->cp_master_event_finish,
          'event_name1' => !empty($requests->cp_master_event_name1)&&!empty($requests->cp_master_board_flag)?$requests->cp_master_event_name1:null,
          'event_name2' => !empty($requests->cp_master_event_name2)&&!empty($requests->cp_master_board_flag)?$requests->cp_master_event_name2:null,
          'event_owner' => !empty($requests->cp_master_event_owner)&&!empty($requests->cp_master_board_flag)?$requests->cp_master_event_owner:null,
          'luggage_count' => $requests->cp_master_luggage_count,
          'luggage_arrive' => $requests->cp_master_luggage_arrive,
          'luggage_return' => $requests->cp_master_luggage_return,
          'email_flag' => $requests->cp_master_email_flag,
          'in_charge' => $requests->cp_master_in_charge,
          'tel' => $requests->cp_master_tel,
          'discount_condition' => $requests->cp_master_discount_condition,
          'attention' => $requests->cp_master_attention,
          'admin_details' => $requests->cp_master_admin_details,
          'status' => 0,
          'eat_in' => $requests->cp_master_eat_in,
          'eat_in_prepare' => $requests->cp_master_eat_in_prepare,
          'luggage_flag' => ($requests->cp_master_luggage_flag === '1' || $requests->luggage_flag === '1') ? 1 : 0,
          'cost' => $requests->cp_master_cost,
        ]);

        $venue_price = empty($result[0][$key][0]) ? 0 : $result[0][$key][0];
        $equipment_price = empty($result[1][0]) ? 0 : $result[1][0];
        $layout_price = empty($result[2][2]) ? 0 : $result[2][2];
        $luggage_price = $requests->cp_master_luggage_price ? $requests->cp_master_luggage_price : 0;

        $master = $venue_price + $equipment_price + $layout_price + $luggage_price;

        if (empty($pre_reservation->pre_bill)) {
          $pre_bill = $pre_reservation->pre_bill()->create([
            'venue_price' => $venue_price,
            'equipment_price' => $equipment_price + ((int) $requests->cp_master_luggage_price),
            'layout_price' => $layout_price,
            'others_price' => 0, //othersは後ほど
            'master_subtotal' => floor($master),
            'master_tax' => floor($master * 0.1),
            'master_total' => floor(($master) + ($master * 0.1)),
            'reservation_status' => 0,
            'category' => 1,
            'end_user_charge' => 0, //ユーザーからは0で固定
          ]);
        } else {
          $pre_reservation->pre_breakdowns()->delete();
          $pre_reservation->pre_bill()->delete();
          $pre_bill = $pre_reservation->pre_bill()->create([
            'venue_price' => $venue_price,
            'equipment_price' => $equipment_price + ((int) $requests->cp_master_luggage_price),
            'layout_price' => $layout_price,
            'others_price' => 0, //othersは後ほど
            'master_subtotal' => floor($master),
            'master_tax' => floor($master * 0.1),
            'master_total' => floor(($master) + ($master * 0.1)),
            'reservation_status' => 0,
            'category' => 1,
            'end_user_charge' => 0, //ユーザーからは0で固定
          ]);
        }

        if (!empty($result[0][$key][1])) {
          $venue_prices = ['会場料金', ($result[0][$key][0]-$result[0][$key][1]), $result[0][$key][3] , $result[0][$key][0]];
          $extend_prices = ['延長料金', $result[0][$key][1], $result[0][$key][4], $result[0][$key][1]];
        } elseif (empty($result[0][$key][0])) {
          $venue_prices = [];
          $extend_prices = [];
        } else {
          $venue_prices = ['会場料金', ($result[0][$key][0]-$result[0][$key][1]), $result[0][$key][3] , $result[0][$key][0]];
          $extend_prices = [];
        }

        if ($venue_price != 0) {
          if ($extend_prices) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $venue_prices[0],
              'unit_cost' => $venue_prices[1],
              'unit_count' => $venue_prices[2],
              'unit_subtotal' => $venue_prices[1],
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
              'unit_subtotal' => $venue_prices[1],
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

        if ($requests->cp_master_luggage_price) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => '荷物預かり',
            'unit_cost' => $requests->cp_master_luggage_price,
            'unit_count' => 1,
            'unit_subtotal' => $requests->cp_master_luggage_price,
            'unit_type' => 3,
          ]);
        }

        $prepare = Venue::find($venue_id)->layout_prepare;
        if ($requests->cp_master_layout_prepare == 1) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => 'レイアウト準備料金',
            'unit_cost' => $prepare,
            'unit_count' => 1,
            'unit_subtotal' => $prepare,
            'unit_type' => 4,
          ]);
        }

        $clean = Venue::find($venue_id)->layout_clean;
        if ($requests->cp_master_layout_clean == 1) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => 'レイアウト片付料金',
            'unit_cost' => $clean,
            'unit_count' => 1,
            'unit_subtotal' => $clean,
            'unit_type' => 4,
          ]);
        }
      }
    });
  }

  public function UpdateAndReCreateAll($masterData, $venues_id)
  {
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venues_id)->get();

    DB::transaction(function () use ($pre_reservations, $masterData) {
      foreach ($pre_reservations as $key => $pre_reserve) {
        $pre_reserve->pre_breakdowns()->delete();
        $pre_reserve->pre_bill()->delete();

        $pre_bill = $pre_reserve->pre_bill()->create([
          'venue_price' => empty($masterData->{'venue_price' . $key}) ? 0 : $masterData->{'venue_price' . $key},
          'equipment_price' => empty($masterData->{'equipment_price' . $key}) ? 0 : $masterData->{'equipment_price' . $key},
          'layout_price' => empty($masterData->{'layout_price' . $key}) ? 0 : $masterData->{'layout_price' . $key},
          'others_price' => empty($masterData->{'others_price' . $key}) ? 0 : $masterData->{'others_price' . $key},
          'master_subtotal' => empty($masterData->{'master_subtotal' . $key}) ? 0 : $masterData->{'master_subtotal' . $key},
          'master_tax' => empty($masterData->{'master_tax' . $key}) ? 0 : $masterData->{'master_tax' . $key},
          'master_total' => empty($masterData->{'master_total' . $key}) ? 0 : $masterData->{'master_total' . $key},
          'reservation_status' => 0,
          'category' => 1,
          'end_user_charge' => 0, //ユーザーからは0で固定
        ]);
        // 以下入力された会場
        $s_venue = [];
        foreach ($masterData as $s_v_key => $value) {
          if (preg_match('/venue_breakdown_item/', $s_v_key)) {
            $s_venue[$s_v_key] = $value;
          }
          if (preg_match('/venue_breakdown_cost/', $s_v_key)) {
            $s_venue[$s_v_key] = $value;
          }
          if (preg_match('/venue_breakdown_count/', $s_v_key)) {
            $s_venue[$s_v_key] = $value;
          }
          if (preg_match('/venue_breakdown_subtotal/', $s_v_key)) {
            $s_venue[$s_v_key] = $value;
          }
        }

        $re_venue = [];
        foreach ($s_venue as $re_v_key => $value) {
          if (preg_match('/_copied' . $key . '/', $re_v_key)) {
            $re_venue[] = $value;
          }
        }
        $judge_re_venue = array_filter($re_venue);
        if (!empty($judge_re_venue)) {
          for ($i = 0; $i < count($re_venue) / 4; $i++) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $re_venue[($i * 4)],
              'unit_cost' => $re_venue[($i * 4) + 1],
              'unit_count' => $re_venue[($i * 4) + 2],
              'unit_subtotal' => $re_venue[($i * 4) + 3],
              'unit_type' => 1,
            ]);
          }
        }

        // 入力された会場の割引
        $venue_discounts = [];
        foreach ($masterData as $v_d_key => $value) {
          if (preg_match('/venue_breakdown_discount_item' . $key . '/', $v_d_key)) {
            $venue_discounts[] = $value;
          }
          if (preg_match('/venue_breakdown_discount_cost' . $key . '/', $v_d_key)) {
            $venue_discounts[] = $value;
          }
          if (preg_match('/venue_breakdown_discount_count' . $key . '/', $v_d_key)) {
            $venue_discounts[] = $value;
          }
          if (preg_match('/venue_breakdown_discount_subtotal' . $key . '/', $v_d_key)) {
            $venue_discounts[] = $value;
          }
        }

        $judge_venue_discounts = array_filter($venue_discounts);
        if (!empty($judge_venue_discounts)) {
          if ($venue_discounts) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $venue_discounts[0],
              'unit_cost' => $venue_discounts[1],
              'unit_count' => $venue_discounts[2],
              'unit_subtotal' => $venue_discounts[3],
              'unit_type' => 1,
            ]);
          }
        }

        // 以下入力された備品
        $s_equipment = [];
        foreach ($masterData as $s_e_key => $value) {
          if (preg_match('/equipment_breakdown_item/', $s_e_key)) {
            $s_equipment[$s_e_key] = $value;
          }
          if (preg_match('/equipment_breakdown_count/', $s_e_key)) {
            $s_equipment[$s_e_key] = $value;
          }
          if (preg_match('/equipment_breakdown_cost/', $s_e_key)) {
            $s_equipment[$s_e_key] = $value;
          }
          if (preg_match('/equipment_breakdown_subtotal/', $s_e_key)) {
            $s_equipment[$s_e_key] = $value;
          }
        }

        $re_equipment = [];
        foreach ($s_equipment as $re_e_key => $value) {
          if (preg_match('/_copied' . $key . '/', $re_e_key)) {
            $re_equipment[] = $value;
          }
        }

        $judge_re_equipment = array_filter($re_equipment);
        if (!empty($judge_re_equipment)) {
          for ($i = 0; $i < count($re_equipment) / 4; $i++) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $re_equipment[($i * 4)],
              'unit_cost' => $re_equipment[($i * 4) + 1],
              'unit_count' => $re_equipment[($i * 4) + 2],
              'unit_subtotal' => $re_equipment[($i * 4) + 3],
              'unit_type' => 2,
            ]);
          }
        }

        // 入力された備品の割引
        $equ_discounts = [];
        foreach ($masterData as $e_d_key => $value) {
          if (preg_match('/equipment_breakdown_discount_item' . $key . '/', $e_d_key)) {
            $equ_discounts[] = $value;
          }
          if (preg_match('/equipment_breakdown_discount_cost' . $key . '/', $e_d_key)) {
            $equ_discounts[] = $value;
          }
          if (preg_match('/equipment_breakdown_discount_count' . $key . '/', $e_d_key)) {
            $equ_discounts[] = $value;
          }
          if (preg_match('/equipment_breakdown_discount_subtotal' . $key . '/', $e_d_key)) {
            $equ_discounts[] = $value;
          }
        }

        $judge_equ_discounts = array_filter($equ_discounts);
        if (!empty($judge_equ_discounts)) {
          if ($equ_discounts) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $equ_discounts[0],
              'unit_cost' => $equ_discounts[1],
              'unit_count' => $equ_discounts[2],
              'unit_subtotal' => $equ_discounts[3],
              'unit_type' => 2,
            ]);
          }
        }

        // 以下入力されたサービス
        $s_service = [];
        foreach ($masterData as $s_s_key => $value) {
          if (preg_match('/services_breakdown_item/', $s_s_key)) {
            $s_service[$s_s_key] = $value;
          }
          if (preg_match('/services_breakdown_cost/', $s_s_key)) {
            $s_service[$s_s_key] = $value;
          }
          if (preg_match('/services_breakdown_count/', $s_s_key)) {
            $s_service[$s_s_key] = $value;
          }
          if (preg_match('/services_breakdown_subtotal/', $s_s_key)) {
            $s_service[$s_s_key] = $value;
          }
        }

        $re_service = [];
        foreach ($s_service as $re_s_key => $value) {
          if (preg_match('/_copied' . $key . '/', $re_s_key)) {
            $re_service[] = $value;
          }
        }

        $judge_re_service = array_filter($re_service);
        if (!empty($judge_re_service)) {
          for ($i = 0; $i < count($re_service) / 4; $i++) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $re_service[($i * 4)],
              'unit_cost' => $re_service[($i * 4) + 1],
              'unit_count' => $re_service[($i * 4) + 2],
              'unit_subtotal' => $re_service[($i * 4) + 3],
              'unit_type' => 3,
            ]);
          }
        }

        // 以下入力されたレイアウト
        $s_layouts = [];
        foreach ($masterData as $s_l_key => $value) {
          if (preg_match('/layout_breakdown_item/', $s_l_key)) {
            $s_layouts[$s_l_key] = $value;
          }
          if (preg_match('/layout_breakdown_cost/', $s_l_key)) {
            $s_layouts[$s_l_key] = $value;
          }
          if (preg_match('/layout_breakdown_count/', $s_l_key)) {
            $s_layouts[$s_l_key] = $value;
          }
          if (preg_match('/layout_breakdown_subtotal/', $s_l_key)) {
            $s_layouts[$s_l_key] = $value;
          }
        }

        $re_layouts = [];
        foreach ($s_layouts as $re_l_key => $value) {
          if (preg_match('/_copied' . $key . '/', $re_l_key)) {
            $re_layouts[] = $value;
          }
        }
        $judge_re_layouts = array_filter($re_layouts);
        if (!empty($judge_re_layouts)) {
          for ($i = 0; $i < count($re_layouts) / 4; $i++) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $re_layouts[($i * 4)],
              'unit_cost' => $re_layouts[($i * 4) + 1],
              'unit_count' => $re_layouts[($i * 4) + 2],
              'unit_subtotal' => $re_layouts[($i * 4) + 3],
              'unit_type' => 4,
            ]);
          }
        }

        // 入力されたレイアウトの割引
        $lay_discounts = [];
        foreach ($masterData as $l_d_key => $value) {
          if (preg_match('/layout_breakdown_discount_item' . $key . '/', $l_d_key)) {
            $lay_discounts[] = $value;
          }
          if (preg_match('/layout_breakdown_discount_cost' . $key . '/', $l_d_key)) {
            $lay_discounts[] = $value;
          }
          if (preg_match('/layout_breakdown_discount_count' . $key . '/', $l_d_key)) {
            $lay_discounts[] = $value;
          }
          if (preg_match('/layout_breakdown_discount_subtotal' . $key . '/', $l_d_key)) {
            $lay_discounts[] = $value;
          }
        }
        $judge_lay_discounts = array_filter($lay_discounts);
        if (!empty($judge_lay_discounts)) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => $lay_discounts[0],
            'unit_cost' => $lay_discounts[1],
            'unit_count' => $lay_discounts[2],
            'unit_subtotal' => $lay_discounts[3],
            'unit_type' => 4,
          ]);
        }

        // 以下入力されたothers
        $s_others = [];
        foreach ($masterData as $s_o_key => $value) {
          if (preg_match('/others_input_item/', $s_o_key)) {
            $s_others[$s_o_key] = $value;
          }
          if (preg_match('/others_input_cost/', $s_o_key)) {
            $s_others[$s_o_key] = $value;
          }
          if (preg_match('/others_input_count/', $s_o_key)) {
            $s_others[$s_o_key] = $value;
          }
          if (preg_match('/others_input_subtotal/', $s_o_key)) {
            $s_others[$s_o_key] = $value;
          }
        }
        $re_others = [];
        foreach ($s_others as $re_o_key => $value) {
          if (preg_match('/_copied' . $key . '/', $re_o_key)) {
            $re_others[] = $value;
          }
        }
        $judge_re_others = array_filter($re_others);
        if (!empty($judge_re_others)) {
          for ($i = 0; $i < count($re_others) / 4; $i++) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $re_others[($i * 4)],
              'unit_cost' => $re_others[($i * 4) + 1],
              'unit_count' => $re_others[($i * 4) + 2],
              'unit_subtotal' => $re_others[($i * 4) + 3],
              'unit_type' => 5,
            ]);
          }
        }
      }
    });
  }

  public function MultipleStore($request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $counters = [];
      foreach ($request->all() as $key => $value) {
        if (preg_match('/pre_date/', $key)) {
          $counters[] = $value;
        }
      }
      $counters = count($counters);
      for ($i = 0; $i < $counters; $i++) {
        $pre_reservations = $this->pre_reservations()->create([
          'venue_id' => $request->{'pre_venue' . $i},
          'user_id' => $request->user_id,
          'agent_id' => 0,
          'reserve_date' => $request->{'pre_date' . $i},
          'enter_time' => $request->{'pre_enter' . $i},
          'leave_time' => $request->{'pre_leave' . $i},
          'status' => 0,
          'luggage_flag' => 0
        ]);

        if (!empty($request->unknown_user_company) || !empty($request->unknown_user_name) || !empty($request->unknown_user_tel) || !empty($request->unknown_user_mobile) || !empty($request->unknown_user_email)) {
          $unknown = $pre_reservations->unknown_user()->count();
          if ($unknown == 0) {
            $pre_reservations->unknown_user()->create([
              "unknown_user_company" => $request->unknown_user_company,
              "unknown_user_name" => $request->unknown_user_name,
              "unknown_user_email" => $request->unknown_user_email,
              "unknown_user_mobile" => $request->unknown_user_mobile,
              "unknown_user_tel" => $request->unknown_user_tel,
            ]);
          } else {
            $pre_reservations->unknown_user()->delete();
            $pre_reservations->unknown_user()->create([
              "unknown_user_company" => $request->unknown_user_company,
              "unknown_user_name" => $request->unknown_user_name,
              "unknown_user_email" => $request->unknown_user_email,
              "unknown_user_mobile" => $request->unknown_user_mobile,
              "unknown_user_tel" => $request->unknown_user_tel,
            ]);
          }
        }
      }
    });
  }

  public function MultipleStoreForAgent($request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $counters = [];
      foreach ($request->all() as $key => $value) {
        if (preg_match('/pre_date/', $key)) {
          $counters[] = $value;
        }
      }
      $counters = count($counters);
      for ($i = 0; $i < $counters; $i++) {
        $pre_reservations = $this->pre_reservations()->create([
          'venue_id' => $request->{'pre_venue' . $i},
          'user_id' => 0,
          'agent_id' => $request->agent_id,
          'reserve_date' => $request->{'pre_date' . $i},
          'enter_time' => $request->{'pre_enter' . $i},
          'leave_time' => $request->{'pre_leave' . $i},
          'status' => 0,
          'luggage_flag' => 0
        ]);

        if ($request->pre_enduser_company || $request->pre_enduser_name || $request->pre_enduser_address || $request->pre_enduser_tel || $request->pre_enduser_mobile || $request->pre_enduser_email || $request->pre_enduser_attr) {
          $pre_reservations->pre_enduser()->create([
            "company" => $request->pre_enduser_company,
            "person" => $request->pre_enduser_name,
            "email" => $request->pre_enduser_email,
            "mobile" => $request->pre_enduser_mobile,
            "tel" => $request->pre_enduser_tel,
            "address" => $request->pre_enduser_address,
            "attr" => $request->pre_enduser_attr,
            "charge" => 0,
          ]);
        }
      }
    });
  }


  public function AgentPreStore($venue_id, $requests, $result)
  {
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->orderBy('id')->get();

    DB::transaction(function () use ($venue_id, $requests, $result, $pre_reservations) {
      foreach ($pre_reservations as $key => $pre_reservation) {
        $pre_reservation->update([
          'price_system' => $requests->cp_master_price_system,
          'board_flag' => $requests->cp_master_board_flag,
          'event_start' => $requests->cp_master_event_start,
          'event_finish' => $requests->cp_master_event_finish,
          'event_name1' => !empty($requests->cp_master_event_name1)&&!empty($requests->cp_master_board_flag)?$requests->cp_master_event_name1:null,
          'event_name2' => !empty($requests->cp_master_event_name2)&&!empty($requests->cp_master_board_flag)?$requests->cp_master_event_name2:null,
          'event_owner' => !empty($requests->cp_master_event_owner)&&!empty($requests->cp_master_board_flag)?$requests->cp_master_event_owner:null,
          'luggage_count' => $requests->cp_master_luggage_count,
          'luggage_arrive' => $requests->cp_master_luggage_arrive,
          'luggage_return' => $requests->cp_master_luggage_return,
          'email_flag' => $requests->cp_master_email_flag,
          'discount_condition' => $requests->cp_master_discount_condition,
          'attention' => $requests->cp_master_attention,
          'admin_details' => $requests->cp_master_admin_details,
          'status' => 0,
          'eat_in' => $requests->cp_master_eat_in,
          'eat_in_prepare' => $requests->cp_master_eat_in_prepare,
          'cost' => $requests->cp_master_cost,
          'luggage_return' => $requests->cp_master_luggage_return,
          'luggage_flag' => !empty($requests->luggage_flag) ? $requests->luggage_flag : 0,
        ]);

        if ($pre_reservation->pre_enduser()->count() == 1) {
          $pre_reservation->pre_enduser()->update([
            "charge" => $requests->cp_master_end_user_charge,
          ]);
        } else {
          $pre_reservation->pre_enduser()->create([
            "charge" => $requests->cp_master_end_user_charge,
          ]);
        }

        $venue_price = 0;
        $equipment_price = 0;
        $layout_calc = Venue::find($venue_id);
        $layout_price = $layout_calc->getLayoutPrice($requests->cp_master_layout_prepare, $requests->cp_master_layout_clean)[2];
        $luggage_price = 0;

        $master = $result + $layout_price;


        if (empty($pre_reservation->pre_bill)) {
          $pre_bill = $pre_reservation->pre_bill()->create([
            'venue_price' => 0,
            'equipment_price' => 0,
            'layout_price' => $layout_price,
            'others_price' => 0, //othersは後ほど
            'master_subtotal' => floor($master),
            'master_tax' => floor($master * 0.1),
            'master_total' => floor(($master) + ($master * 0.1)),
            'reservation_status' => 0,
            'category' => 1,
            'end_user_charge' => $requests->cp_master_end_user_charge,
          ]);
        } else {
          $pre_reservation->pre_breakdowns()->delete();
          $pre_reservation->pre_bill()->delete();
          $pre_bill = $pre_reservation->pre_bill()->create([
            'venue_price' => 0,
            'equipment_price' => 0,
            'layout_price' => $layout_price,
            'others_price' => 0, //othersは後ほど
            'master_subtotal' => floor($master),
            'master_tax' => floor($master * 0.1),
            'master_total' => floor(($master) + ($master * 0.1)),
            'reservation_status' => 0,
            'category' => 1,
            'end_user_charge' => $requests->cp_master_end_user_charge,
          ]);
        }


        $carbon1 = new Carbon($pre_reservation->enter_time);
        $carbon2 = new Carbon($pre_reservation->leave_time);

        $pre_bill->pre_breakdowns()->create([
          'unit_item' => "会場料金",
          'unit_cost' => 0,
          'unit_count' => 1,
          'unit_subtotal' => 0,
          'unit_type' => 1,
        ]);


        $equipments = Venue::find($venue_id);
        foreach ($equipments->equipments()->get() as $key => $equ) {
          if ($requests->{'cp_master_equipment_breakdown' . $key}) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $equ->item,
              'unit_cost' => 0,
              'unit_count' => $requests->{'cp_master_equipment_breakdown' . $key},
              'unit_subtotal' => 0,
              'unit_type' => 2,
            ]);
          }
        }

        $services = Venue::find($venue_id);
        foreach ($services->services()->get() as $key => $ser) {
          if ($requests->{'cp_master_services_breakdown' . $key} != 0) {
            $pre_bill->pre_breakdowns()->create([
              'unit_item' => $ser->item,
              'unit_cost' => 0,
              'unit_count' => $requests->{'cp_master_services_breakdown' . $key},
              'unit_subtotal' => 0,
              'unit_type' => 3,
            ]);
          }
        }

        if ($requests->cp_master_luggage_price) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => '荷物預かり',
            'unit_cost' => 0,
            'unit_count' => 1,
            'unit_subtotal' => 0,
            'unit_type' => 3,
          ]);
        }

        $prepare = Venue::find($venue_id)->layout_prepare;
        if ($requests->cp_master_layout_prepare == 1) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => 'レイアウト準備料金',
            'unit_cost' => $prepare,
            'unit_count' => 1,
            'unit_subtotal' => $prepare,
            'unit_type' => 4,
          ]);
        }

        $clean = Venue::find($venue_id)->layout_clean;
        if ($requests->cp_master_layout_clean == 1) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => 'レイアウト片付料金',
            'unit_cost' => $clean,
            'unit_count' => 1,
            'unit_subtotal' => $clean,
            'unit_type' => 4,
          ]);
        }
      }
    });
  }

  public function checkVenuePrice()
  {
    $judge = [];
    foreach ($this->pre_reservations as $key => $value) {
      if (!empty($value->pre_bill)) {
        if (is_null($value->pre_bill->venue_price)) {
          $judge[] = 0;
        } else {
          $judge[] = 1;
        }
      } else {
        $judge[] = 0;
      }
    }
    return in_array(0, $judge);
  }

  public function checkEachStatus()
  {
    $judge = [];
    foreach ($this->pre_reservations as $key => $value) {
      $judge[] = $value->status;
    }
    return in_array(0, $judge);
  }

  public function checkEachBills()
  {
    foreach ($this->pre_reservations as $pre_reservation) {
      if (is_null($pre_reservation->pre_bill)) {
        return FALSE;
        break;
      }
      return TRUE;
    }
  }


  /**   
   * 予約一覧の検索対象マスタ
   * @return object collectionで返る
   */
  public function MultipleSearchTarget()
  {
    $searchTarget = DB::table('multiple_reserves')
      ->select(DB::raw(
        "
         LPAD(multiple_reserves.id,6,0) as multiple_reserve_id,
        multiple_reserves.id as multiple_reserve_original_id,
        concat(date_format(multiple_reserves.created_at, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(multiple_reserves.created_at) = 1 then '(日)' 
        when DAYOFWEEK(multiple_reserves.created_at) = 2 then '(月)'
        when DAYOFWEEK(multiple_reserves.created_at) = 3 then '(火)'
        when DAYOFWEEK(multiple_reserves.created_at) = 4 then '(水)'
        when DAYOFWEEK(multiple_reserves.created_at) = 5 then '(木)'
        when DAYOFWEEK(multiple_reserves.created_at) = 6 then '(金)'
        when DAYOFWEEK(multiple_reserves.created_at) = 7 then '(土)'
        end
        ) as created_at,
        count(pre_reservations.id) as pre_reservation_count,
        min(pre_reservations.id) as pre_reservation_id,
        min(pre_reservations.user_id) as user_id,
        users.company as company,
        concat(users.first_name, users.last_name) as person_name,
        users.mobile as mobile,
        users.tel as tel,
        users.attention as attention,
        unknown_users.unknown_user_company as unknown_user_company,
        agents.name as agent_name,
        pre_endusers.company as enduser,
        sum(pre_reservations.status) as pre_status
        "
      ))
      ->leftJoin('pre_reservations', 'multiple_reserves.id', '=', 'pre_reservations.multiple_reserve_id')
      ->leftJoin('users', 'pre_reservations.user_id', '=', 'users.id')
      ->leftJoin('unknown_users', 'pre_reservations.id', '=', 'unknown_users.pre_reservation_id')
      ->leftJoin('agents', 'pre_reservations.agent_id', '=', 'agents.id')
      ->leftJoin('pre_endusers', 'pre_reservations.id', '=', 'pre_endusers.pre_reservation_id')
      ->groupByRaw("multiple_reserves.id, users.id, unknown_users.unknown_user_company, agents.name, pre_endusers.company, multiple_reserves.created_at, users.company, users.first_name, users.last_name, users.mobile, users.tel, users.attention")
      ->havingRaw('pre_reservation_count > 0');
    return $searchTarget;
  }

  public function SearchMultiple($data)
  {
    $searchTarget = $this->MultipleSearchTarget();

    if (isset($data['search_id']) && $data['search_id'] !== '') {
      $searchId = (int)$data['search_id'];
      $searchTarget->whereRaw('multiple_reserve_id like ? ',  $searchId . '%');
    }

    if (!empty($data['search_created_at'])) {
      $targetData = explode(" ~ ", $data['search_created_at']);
      $targetData[0] = $targetData[0] . ' 00:00:00';
      $targetData[1] = $targetData[1] . ' 23:59:59';
      $searchTarget->whereRaw('pre_reservations.created_at between ? AND ? ',  $targetData);
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
      $searchTarget->whereRaw('pre_reservations.status = ? and pre_reservations.created_at < DATE_SUB(CURRENT_DATE(),INTERVAL ? DAY) ', [1, 3]);
    }

    if (isset($data['search_role'])) {
      if ((int)$data['search_role'] === 0) {
        $searchTarget->havingRaw('pre_status = ? ',  [0]);
      } elseif ((int)$data['search_role'] === 1) {
        $searchTarget->havingRaw('pre_status > ? ',  [0]);
      }
    }

    if (!empty($data['search_free'])) {
      if (preg_match('/^[0-9!,]+$/', $data['search_free'])) {
        //数字の場合検索
        if ((int)$data['search_free'] !== 0) {
          $searchTarget = $searchTarget->where(function ($query) use ($data) {
            for ($i = 0; $i < strlen($data['search_free']); $i++) {
              if ((int)$data['search_free'][$i] !== 0) {
                $id = substr($data['search_free'], $i, strlen($data['search_free']));
                break;
              }
            }
            $query->whereRaw('multiple_reserves.id LIKE ? ', ['%' . $id . '%'])
              ->orWhereRaw('users.mobile LIKE ? ', ['%' . $data['search_free'] . '%'])
              ->orWhereRaw('users.tel LIKE ? ', ['%' . $data['search_free'] . '%']);
          });
        }
      } elseif (preg_match('/^[0-9!-]+$/', $data['search_free'])) {
        //○○○○-○○-○○の日付が来た際
        $searchTarget = $searchTarget->where(function ($query) use ($data) {
          if (!empty($data['search_free'])) {
            $query->orWhereRaw('multiple_reserves.created_at between ? AND ?', [$data['search_free'] . ' 00:00:00', $data['search_free'] . ' 23:59:59']);
          }
        });
      } else {
        //文字列の場合
        $searchTarget = $searchTarget->where(function ($query) use ($data) {
          if (!empty($data['search_free'])) {
            $query->whereRaw('users.company LIKE ?', ['%' . $data['search_free'] . '%'])
              ->orWhereRaw('concat(users.first_name, users.last_name) LIKE ?', ['%' . $data['search_free'] . '%'])
              ->orWhereRaw('agents.name LIKE ?', ['%' . $data['search_free'] . '%'])
              ->orWhereRaw('unknown_users.unknown_user_company LIKE ?', ['%' . $data['search_free'] . '%'])
              ->orWhereRaw('agents.name LIKE ?', ['%' . $data['search_free'] . '%'])
              ->orWhereRaw('pre_endusers.company LIKE ?', ['%' . $data['search_free'] . '%']);
          }
        });
      }
    }


    return $searchTarget;
  }

  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->pre_reservations()->get() as $child) {
        $child->delete();
      }
    });
  }
}
