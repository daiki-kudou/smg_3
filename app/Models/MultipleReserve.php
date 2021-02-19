<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Presenters\MultipleReservePresenter; //個別作成したプレゼンターの追加
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Models\Venue;
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
    foreach ($pre_reservations as $key => $pre_reservation) {
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

      echo "<pre>";
      var_dump('区切り■■■■■■■■■■■');
      var_dump($venue_prices);
      var_dump($extend_prices);
      var_dump('区切り■■■■■■■■■■■');
      echo "</pre>";

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
      $pre_bill = $pre_reservation->pre_bills()->updateOrCreate([
        'venue_price' => $result[0][$key][2],
        'equipment_price' => $result[1][0],
        'layout_price' => $result[2][2],
        'others_price' => 0, //othersは後ほど
        'master_subtotal' => 0, //これも後ほど
        'master_tax' => 0, //これも後ほど
        'master_total' => 0, //これも後ほど
        'reservation_status' => 0,
        'category' => 1
      ]);

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

      // $pre_bill->pre_breakdowns()->create([
      //   'unit_item'=>
      // ]);



    }
  }
}
