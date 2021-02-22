<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Presenters\MultipleReservePresenter; //個別作成したプレゼンターの追加
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Models\Venue;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use Illuminate\Support\Facades\DB; //トランザクション用



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
    $venue = Venue::find($venue_id);
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
          'event_name1' => $requests->cp_master_event_name1,
          'event_name2' => $requests->cp_master_event_name2,
          'event_owner' => $requests->cp_master_event_owner,
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
        ]);

        $venue_price = empty($result[0][$key][2]) ? 0 : $result[0][$key][2];
        $equipment_price = empty($result[1][0]) ? 0 : $result[1][0];
        $layout_price = empty($result[2][2]) ? 0 : $result[2][2];

        $master = $venue_price + $equipment_price + $layout_price;

        if (empty($pre_reservation->pre_bill)) {
          $pre_bill = $pre_reservation->pre_bill()->create([
            'venue_price' => $venue_price,
            'equipment_price' => $equipment_price + ((int)$requests->cp_master_luggage_price),
            'layout_price' => $layout_price,
            'others_price' => 0, //othersは後ほど
            'master_subtotal' => floor($master),
            'master_tax' => floor($master * 0.1),
            'master_total' => floor(($master) + ($master * 0.1)),
            'reservation_status' => 0,
            'category' => 1
          ]);
        } else {
          $pre_reservation->pre_breakdowns()->delete();
          $pre_reservation->pre_bill()->delete();
          $pre_bill = $pre_reservation->pre_bill()->create([
            'venue_price' => $venue_price,
            'equipment_price' => $equipment_price + ((int)$requests->cp_master_luggage_price),
            'layout_price' => $layout_price,
            'others_price' => 0, //othersは後ほど
            'master_subtotal' => floor($master),
            'master_tax' => floor($master * 0.1),
            'master_total' => floor(($master) + ($master * 0.1)),
            'reservation_status' => 0,
            'category' => 1
          ]);
        }

        if (!empty($result[0][$key][1])) {
          $venue_prices = ['会場料金', $result[0][$key][0], $result[0][$key][3] - $result[0][$key][4], $result[0][$key][0]];
          $extend_prices = ['延長料金', $result[0][$key][1], $result[0][$key][4], $result[0][$key][1]];
        } elseif (empty($result[0][$key][0])) {
          $venue_prices = [];
          $extend_prices = [];
        } else {
          $venue_prices = ['会場料金', $result[0][$key][0], $result[0][$key][3] - $result[0][$key][4], $result[0][$key][0]];
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

        var_dump($requests->cp_master_luggage_price);
        if ($requests->cp_master_luggage_price) {
          $pre_bill->pre_breakdowns()->create([
            'unit_item' => '荷物預かり/返送',
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

  public function UpdateAndReCreateAll($masterData)
  {
    // $numPreReservation = $this->pre_reservations()->get()->count();
    // var_dump($numPreReservation);



    $pre_reservations = $this->pre_reservations()->get();

    DB::transaction(function () use ($pre_reservations, $masterData) {
      foreach ($pre_reservations as $key => $pre_reserve) {
        // $pre_reserve->pre_breakdowns()->delete();
        // $pre_reserve->pre_bill()->delete();
        // $pre_bill=$pre_reserve->pre_bill()->create([
        //   'venue_price' => $masterData->{'venue_price' . $key},
        //   'equipment_price' => $masterData->{'equipment_price' . $key}, + ((int)$masterData->{'luggage_price_copied0' . $key}),
        //   'layout_price' => $masterData->{'layout_price' . $key},
        //   'others_price' => $masterData->{'others_price' . $key},
        //   'master_subtotal' => $masterData->{'master_subtotal' . $key},
        //   'master_tax' => $masterData->{'master_tax' . $key},
        //   'master_total' => $masterData->{'master_total' . $key},
        //   'reservation_status' => 0,
        //   'category' => 1
        // ]);

        //////////////////////////////////////////////////////////////////////////
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
            $re_venue[$re_v_key] = $value;
          }
        }

        // 入力された会場の割引
        $venue_discounts = [];
        foreach ($masterData as $v_d_key => $value) {
          if (preg_match('/venue_breakdown_discount_item' . $key . '/', $v_d_key)) {
            $venue_discounts[$v_d_key] = $value;
          }
          if (preg_match('/venue_breakdown_discount_cost' . $key . '/', $v_d_key)) {
            $venue_discounts[$v_d_key] = $value;
          }
          if (preg_match('/venue_breakdown_discount_count' . $key . '/', $v_d_key)) {
            $venue_discounts[$v_d_key] = $value;
          }
          if (preg_match('/venue_breakdown_discount_subtotal' . $key . '/', $v_d_key)) {
            $venue_discounts[$v_d_key] = $value;
          }
        }

        echo "<pre>";
        var_dump($re_venue);
        echo "</pre>";

        echo "<pre>";
        var_dump($venue_discounts);
        echo "</pre>";

        // for ($i = 0; $i < count($re_venue) / 4; $i++) {
        //   $pre_bill->pre_breakdowns()->create([
        //     'unit_item' => 
        //     'unit_cost' => 
        //     'unit_count' => 
        //     'unit_subtotal' => 
        //     'unit_type' => 1,
        //   ]);
        }



        //////////////////////////////////////////////////////////////////////////
        // 以下入力された備品

        // $s_equipment = [];
        // foreach ($masterData as $s_e_key => $value) {
        //   if (preg_match('/equipment_breakdown_item/', $s_e_key)) {
        //     $s_equipment[$s_e_key] = $value;
        //   }
        //   if (preg_match('/equipment_breakdown_count/', $s_e_key)) {
        //     $s_equipment[$s_e_key] = $value;
        //   }
        //   if (preg_match('/equipment_breakdown_cost/', $s_e_key)) {
        //     $s_equipment[$s_e_key] = $value;
        //   }
        //   if (preg_match('/equipment_breakdown_subtotal/', $s_e_key)) {
        //     $s_equipment[$s_e_key] = $value;
        //   }
        // }

        // $re_equipment = [];
        // foreach ($s_equipment as $re_e_key => $value) {
        //   if (preg_match('/_copied' . $key . '/', $re_e_key)) {
        //     $re_equipment[$re_e_key] = $value;
        //   }
        // }
        // echo "<pre>";
        // var_dump($re_equipment);
        // echo "</pre>";

        // 入力された備品の割引
        // $equ_discounts = [];
        // foreach ($masterData as $e_d_key => $value) {
        //   if (preg_match('/equipment_breakdown_discount_item' . $key . '/', $e_d_key)) {
        //     $equ_discounts[$e_d_key] = $value;
        //   }
        //   if (preg_match('/equipment_breakdown_discount_cost' . $key . '/', $e_d_key)) {
        //     $equ_discounts[$e_d_key] = $value;
        //   }
        //   if (preg_match('/equipment_breakdown_discount_count' . $key . '/', $e_d_key)) {
        //     $equ_discounts[$e_d_key] = $value;
        //   }
        //   if (preg_match('/equipment_breakdown_discount_subtotal' . $key . '/', $e_d_key)) {
        //     $equ_discounts[$e_d_key] = $value;
        //   }
        // }

        // echo "<pre>";
        // var_dump($equ_discounts);
        // echo "</pre>";



        //////////////////////////////////////////////////////////////////////////
        // 以下入力されたサービス

        // $s_service = [];
        // foreach ($masterData as $s_s_key => $value) {
        //   if (preg_match('/services_breakdown_item/', $s_s_key)) {
        //     $s_service[$s_s_key] = $value;
        //   }
        //   if (preg_match('/services_breakdown_cost/', $s_s_key)) {
        //     $s_service[$s_s_key] = $value;
        //   }
        //   if (preg_match('/services_breakdown_count/', $s_s_key)) {
        //     $s_service[$s_s_key] = $value;
        //   }
        //   if (preg_match('/services_breakdown_subtotal/', $s_s_key)) {
        //     $s_service[$s_s_key] = $value;
        //   }
        // }

        // $re_service = [];
        // foreach ($s_service as $re_s_key => $value) {
        //   if (preg_match('/_copied' . $key . '/', $re_s_key)) {
        //     $re_service[$re_s_key] = $value;
        //   }
        // }
        // echo "<pre>";
        // var_dump($re_service);
        // echo "</pre>";

        //////////////////////////////////////////////////////////////////////////
        // 以下入力されたレイアウト

        // $s_layouts = [];
        // foreach ($masterData as $s_l_key => $value) {
        //   if (preg_match('/layout_breakdown_item/', $s_l_key)) {
        //     $s_layouts[$s_l_key] = $value;
        //   }
        //   if (preg_match('/layout_breakdown_cost/', $s_l_key)) {
        //     $s_layouts[$s_l_key] = $value;
        //   }
        //   if (preg_match('/layout_breakdown_count/', $s_l_key)) {
        //     $s_layouts[$s_l_key] = $value;
        //   }
        //   if (preg_match('/layout_breakdown_subtotal/', $s_l_key)) {
        //     $s_layouts[$s_l_key] = $value;
        //   }
        // }

        // $re_layouts = [];
        // foreach ($s_layouts as $re_l_key => $value) {
        //   if (preg_match('/_copied' . $key . '/', $re_l_key)) {
        //     $re_layouts[$re_l_key] = $value;
        //   }
        // }
        // echo "<pre>";
        // var_dump($re_layouts);
        // echo "</pre>";

        // 入力されたレイアウトの割引
        $lay_discounts = [];
        foreach ($masterData as $l_d_key => $value) {
          if (preg_match('/layout_breakdown_discount_item' . $key . '/', $l_d_key)) {
            $lay_discounts[$l_d_key] = $value;
          }
          if (preg_match('/layout_breakdown_discount_cost' . $key . '/', $l_d_key)) {
            $lay_discounts[$l_d_key] = $value;
          }
          if (preg_match('/layout_breakdown_discount_count' . $key . '/', $l_d_key)) {
            $lay_discounts[$l_d_key] = $value;
          }
          if (preg_match('/layout_breakdown_discount_subtotal' . $key . '/', $l_d_key)) {
            $lay_discounts[$l_d_key] = $value;
          }
        }

        echo "<pre>";
        var_dump($lay_discounts);
        echo "</pre>";


        //////////////////////////////////////////////////////////////////////////
        // 以下入力されたothers

        // $s_others = [];
        // foreach ($masterData as $s_o_key => $value) {
        //   if (preg_match('/others_input_item/', $s_o_key)) {
        //     $s_others[$s_o_key] = $value;
        //   }
        //   if (preg_match('/others_input_cost/', $s_o_key)) {
        //     $s_others[$s_o_key] = $value;
        //   }
        //   if (preg_match('/others_input_count/', $s_o_key)) {
        //     $s_others[$s_o_key] = $value;
        //   }
        //   if (preg_match('/others_input_subtotal/', $s_o_key)) {
        //     $s_others[$s_o_key] = $value;
        //   }
        // }

        // $re_others = [];
        // foreach ($s_others as $re_o_key => $value) {
        //   if (preg_match('/_copied' . $key . '/', $re_o_key)) {
        //     $re_others[$re_o_key] = $value;
        //   }
        // }
        // echo "<pre>";
        // var_dump($re_others);
        // echo "</pre>";




      }
    });
  }
}
