<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Presenters\MultipleReservePresenter; //個別作成したプレゼンターの追加
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Models\Venue;


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
    $pre_reservations = $this->pre_reservations()->where('venue_id', $venue_id)->get();

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
}
