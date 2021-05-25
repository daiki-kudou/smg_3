<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon; //carbon利用

use App\Presenters\VenuePresenter; //個別作成したプレゼンターの追加
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use Illuminate\Database\Eloquent\SoftDeletes;



class Venue extends Model implements PresentableInterface
{

  use SoftDeletes;

  /**
   * Return a created presenter.
   *
   * @return Robbo\Presenter\Presenter
   */
  public function getPresenter() //実装したプレゼンタを利用
  {
    return new VenuePresenter($this);
  }

  protected $fillable = [
    'alliance_flag',
    'name_area',
    'name_bldg',
    'name_venue',
    'size1',
    'size2',
    'capacity',
    'eat_in_flag',
    'post_code',
    'address1',
    'address2',
    'address3',
    'remark',
    'first_name',
    'last_name',
    'first_name_kana',
    'last_name_kana',
    'person_tel',
    'person_email',
    'luggage_flag',
    'luggage_tel',
    'cost',
    'mgmt_company',
    'mgmt_tel',
    'mgmt_emer_tel',
    'mgmt_first_name',
    'mgmt_last_name',
    'mgmt_person_tel',
    'mgmt_email',
    'mgmt_sec_company',
    'mgmt_sec_tel',
    'mgmt_remark',
    'entrance_open_time',
    'backyard_open_time',
    'layout',
    'layout_prepare',
    'layout_clean',
  ];


  /*
|--------------------------------------------------------------------------
| 会場と備品の中間テーブル
|--------------------------------------------------------------------------|
*/
  // 【備品】中間テーブル連携
  public function equipments()
  {
    return $this->belongsToMany('App\Models\Equipment')->withTimestamps();
  }

  // 中間テーブル追加
  public function save_equipments($equipment_id)
  {
    $this->equipments()->attach($equipment_id);
    return true;
  }

  // 中間テーブルUpdate
  public function sync_equipments($equipment_id)
  {
    $this->equipments()->sync($equipment_id);
    return true;
  }

  // 中間テーブル削除
  public function detach_equipments()
  {
    $this->equipments()->detach();
    return true;
  }

  /*
|--------------------------------------------------------------------------
| 会場とサービスの中間テーブル
|--------------------------------------------------------------------------|
*/

  // 【サービス】中間テーブル連携
  public function services()
  {
    return $this->belongsToMany('App\Models\Service')->withTimestamps();
  }

  // 【サービス】中間テーブル追加
  public function save_services($service_id)
  {
    $this->services()->attach($service_id);
    return true;
  }

  // 【サービス】中間テーブルsync
  public function sync_services($service_id)
  {
    $this->services()->sync($service_id);
    return true;
  }
  // 【サービス】中間テーブル削除
  public function detach_services()
  {
    $this->services()->detach();
    return true;
  }

  /*
|--------------------------------------------------------------------------
| 会場とDateの中間テーブル
|--------------------------------------------------------------------------|
*/
  // 【日付】一対多
  public function dates()
  {
    return $this->hasMany('App\Models\Date');
  }

  /*
|--------------------------------------------------------------------------
| 枠貸し料金と会場の一対多
|--------------------------------------------------------------------------|
*/
  public function frame_prices()
  {
    return $this->hasMany(FramePrice::class);
  }

  /*
|--------------------------------------------------------------------------
| 時間貸し料金と会場の一対多
|--------------------------------------------------------------------------|
*/
  public function time_prices()
  {
    return $this->hasMany(TimePrice::class);
  }


  /*
|--------------------------------------------------------------------------
| 予約の一対多
|--------------------------------------------------------------------------|
*/
  public function reservations()
  {
    return $this->hasMany(Reservation::class);
  }

  /*
|--------------------------------------------------------------------------
| 仮押えの一対多
|--------------------------------------------------------------------------|
*/
  public function pre_reservations()
  {
    return $this->hasMany(PreReservation::class);
  }


  /*
|--------------------------------------------------------------------------
| 会場の料金計算
|--------------------------------------------------------------------------|
*/
  public function calculate_price($status_id, $start_time, $finish_time)
  {
    if ($status_id == 1) {
      // 時間外を除外
      $this->rejectTime($start_time, $finish_time);

      // 開始時間
      $generate_start_time = $this->generateStartTime($start_time);

      // 終了時間
      $generate_finish_time = $this->generateFinishTime($finish_time);

      // 各料金体系の営業開始・終了時間の範囲取得
      $price_arrays = $this->frame_prices;
      $between_time_list = $this->getEachSalesHours($price_arrays);

      // ↓↓ 一旦ここで、網羅できる料金体系を抽出完了↓↓↓
      $cover_price_result = []; //網羅できる料金体系が格納される
      $extend_lists = []; //延長可能な料金体系のindexと実際に延長する時間が配列で入ってる
      for ($i = 0; $i < count($price_arrays); $i++) {
        // ↓　cover_price_result用
        if (in_array($generate_start_time, $between_time_list[$i]) && in_array($generate_finish_time, $between_time_list[$i])) {
          $cover_price_result[] = $price_arrays[$i];
        } else {
          $cover_price_result[] = "false";
        }
        // ↓　extend_lists用
        if (in_array($generate_start_time, $between_time_list[$i]) && !in_array($generate_finish_time, $between_time_list[$i])) {
          $extend_lists[] = Carbon::parse($generate_finish_time)->diffInMinutes(Carbon::parse($price_arrays[$i]->finish)) / 60;
        } else {
          $extend_lists[] = 'false';
        }
      }

      $extend_prices = []; //1時間もしくは30分の延長料金が入ってる
      foreach ($extend_lists as $extend_list_index => $extend_list_price) {
        if ($extend_list_price == 1) {
          $extend_prices[] = $price_arrays[0]->extend;
        } elseif ($extend_list_price == 0.5) {
          $extend_prices[] = ($price_arrays[0]->extend) / 2;
        } else {
          $extend_prices[] = "false";
        }
      }

      /*|--------------------------------------------------------------------------
      | ↓↓↓一旦ここで、網羅できる料金体系と延長したら網羅できる料金体系の値段表示↓↓↓
      |--------------------------------------------------------------------------|*/
      $extend_final_prices = []; //網羅した場合、延長した場合の料金が入ってる
      for ($extend_final = 0; $extend_final < count($price_arrays); $extend_final++) {
        if ($extend_prices[$extend_final] != 'false') {
          $extend_final_prices[] = ($price_arrays[$extend_final]->price) + ($extend_prices[$extend_final]);
        } elseif ($cover_price_result[$extend_final] != 'false') {
          $extend_final_prices[] = $price_arrays[$extend_final]->price;
        } else {
          $extend_final_prices[] = null;
          $frames[] = null;
        }
      }
      // return $extend_final_prices;
      /*|--------------------------------------------------------------------------
      | ↑↑↑一旦ここで、網羅できる料金体系と延長したら網羅できる料金体系の値段表示↑↑↑
      |--------------------------------------------------------------------------|*/

      $min_results = []; //抽出された料金から最小を取得
      foreach ($extend_final_prices as $extend_final_price) {
        if ($extend_final_price > 0) {
          $min_results[] = $extend_final_price;
        }
      }
      // dd($min_results);
      if (!empty($min_results)) {
        $min_result = min($min_results);
      } else {
        return 0;
      }

      // 延長料金抽出
      $exted_specific_price = $extend_prices[array_search($min_result, $extend_final_prices)];
      if ($exted_specific_price != 'false') {
        $exted_specific_price;
      } elseif ($exted_specific_price == 'false') {
        $exted_specific_price = 0;
      }
      // 延長料金抽出
      switch ($start_time) {
        case '08:00:00':
          $min_result = $min_result + ($price_arrays[0]->extend) * 2;
          $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 2;
          break;
        case '08:30:00':
          $min_result = $min_result + ($price_arrays[0]->extend) * 1.5;
          $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1.5;
          break;
        case '09:00:00':
          $min_result = $min_result + ($price_arrays[0]->extend) * 1.0;
          $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1.0;
          break;
        case '09:30:00':
          $min_result = $min_result + ($price_arrays[0]->extend) * 0.5;
          $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 0.5;
          break;
        case '12:00:00':
          $min_result = $min_result + ($price_arrays[0]->extend) * 1;
          $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1;
          break;
        case '12:30:00':
          $min_result = $min_result + ($price_arrays[0]->extend) * 0.5;
          $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 0.5;
          break;
      }

      // // 23時例外：22時から23時を選択すると時間に応じて延長料金適応
      //17時以降は無条件で夜間料金適応
      if ($finish_time == '23:00:00' && $start_time < '17:00:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 1;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1;
      } elseif ($finish_time == '22:30:00' && $start_time < '17:00:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 0.5;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 0.5;
      }

      // return $min_result; //延長含む最終料金抽出
      // return $extend_prices;

      // 選択した時間取得
      $f_start = Carbon::createFromTimeString($start_time, 'Asia/Tokyo');
      $f_finish = Carbon::createFromTimeString($finish_time, 'Asia/Tokyo');
      $diff = $f_finish->diffInMinutes($f_start);
      $time_diff = $diff / 60;

      // 延長した分の時間取得
      $extend_original = ($price_arrays[0]->extend);
      $extend_diff = $exted_specific_price / $extend_original;
      // min_resultとexted_specific_priceの合計
      $venue_equipments_subtotal = $min_result + $exted_specific_price;
      return [
        $min_result,
        $exted_specific_price,
        $venue_equipments_subtotal,
        $time_diff,
        $extend_diff
      ];

      //＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
      //＊＊会場のステータスが2のとき（アクセア仕様のとき）
      //＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
    } elseif ($status_id == 2) {
      // 時間のベース
      $times_arrays = [
        '3.0', '3.5', '4.0',
        '4.5', '5.0', '5.5',
        '6.0', '6.5', '7.0',
        '7.5', '8.0', '8.5',
        '9.0', '9.5', '10.0',
        '10.5', '11.0', '11.5',
        '12.0', '12.5', '13.0',
        '13.5', '14.0', '14.5', '15.0'
      ];
      $time_price = $this->time_prices()->get();
      // return [$time_price];

      $diff_time_arrays = []; //時差の配列 ここに時差だけ入ってる 
      for ($lists = 0; $lists < count($time_price); $lists++) {
        $target_time = $time_price[$lists]->time;
        $empty_arrays = []; //連想配列pushするための空
        foreach ($times_arrays as $times_array) {
          $empty_arrays[] = [$times_array - $target_time];
        }
        $diff_time_arrays[] = $empty_arrays;
      }

      // すべてのパターンの延長を含む料金の一覧が格納
      $time_price_results = [];
      foreach ($time_price as $keys => $values) {
        $target_time_price = $values->price;
        $target_time_extend = $values->extend;
        $empty_arrays2 = [];
        for ($time_lists = 0; $time_lists < count($times_arrays); $time_lists++) {
          if ($diff_time_arrays[$keys][$time_lists][0] >= 0) {
            $empty_arrays2[] = $target_time_price + ($diff_time_arrays[$keys][$time_lists][0] * $target_time_extend);
          } else {
            $empty_arrays2[] =  'false';
          }
        }
        $time_price_results[] = $empty_arrays2;
      }

      // return $time_price_results;
      $f_start2 = Carbon::createFromTimeString($start_time, 'Asia/Tokyo');
      $f_finish2 = Carbon::createFromTimeString($finish_time, 'Asia/Tokyo');

      $usage_time = $f_start2->diffInMinutes($f_finish2); //時差
      $usage_time /= 60; //分に変換

      if ($usage_time <= 15) {

        $target_time_index_in_array = array_search($usage_time, $times_arrays); //配列のどこに該当があるか
        $empty_arrays3 = [];
        for ($results_lists = 0; $results_lists < count($time_price); $results_lists++) { //⑤回ループ
          $empty_arrays3[] = $time_price_results[$results_lists][$target_time_index_in_array];
        }
        $empty_arrays3result = [];
        foreach ($empty_arrays3 as $empty_array3key => $empty_array3value) {
          if ($empty_array3value > 0) {
            $empty_arrays3result[] = $empty_array3value;
          }
        }
        $time_min_result = min($empty_arrays3result); //■■■■■■■算出した会場＋延長料金■■■■■■■

        $witch_array_in_result = array_search($time_min_result, $empty_arrays3); //どのパターンの結果を参照したのか？ここではパターン１（3H利用）
        $base_result_price = $time_price[$witch_array_in_result]->price; //料金パターン

        $specific_extend_timeprice = $time_min_result - $base_result_price; //specificな延長料金

        $specific_extend_time = $specific_extend_timeprice / ($time_price[$witch_array_in_result]->extend); //speficな延長　時間

        //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
        return [
          $time_min_result - $specific_extend_timeprice,
          $specific_extend_timeprice, //延長料金
          $time_min_result, //合計
          $usage_time - $specific_extend_time, //合計＋延長
          $specific_extend_time
        ];
      } else {
        return FALSE;
      }
    }
  }


  public function rejectTime($start_time, $finish_time)
  {
    if ($start_time < '08:00:00' || $finish_time > '23:00:00') {
      return 0;
    }
  }

  public function generateStartTime($start_time)
  {
    if ($start_time == '17:00:00' || $start_time == '17:30:00') {
      return '18:00:00';
    } elseif ($start_time == '12:00:00' || $start_time == '12:30:00') {
      return  '13:00:00';
    } elseif ($start_time == '08:00:00' || $start_time == '08:30:00' || $start_time == '09:00:00' || $start_time == '09:30:00') {
      return '10:00:00';
    } elseif ($start_time >= '10:00:00' && $start_time <= '19:00:00') {
      return $start_time;
    }
  }

  public function generateFinishTime($finish_time)
  {
    if ($finish_time == '22:30:00' || $finish_time == '23:00:00') {
      return '22:00:00';
    } elseif ($finish_time <= '22:00:00') {
      return $finish_time;
    }
  }

  public function getEachSalesHours($master_array)
  {
    $result = [];
    foreach ($master_array as $price_array) {
      $diff = (Carbon::parse($price_array->start)->diffInMinutes(Carbon::parse($price_array->finish))) / 30;
      $temporary = [];
      for ($i = 0; $i <= $diff; $i++) {
        $temporary[] = date('H:i:s', strtotime(Carbon::parse($price_array->start)->addMinutes($i * 30)));
      }
      // dump($TESTARRAY);
      $result[] = $temporary;
    }
    return $result;
  }


  public function calculate_items_price($selected_equipments, $selected_services)
  {
    // 
    // 備品料金×個数
    $venue_equipments = $this->equipments()->get();
    $equipments_total = 0;
    $equipments_details = [];
    $judge_equipment = array_filter($selected_equipments);
    if (!empty($judge_equipment)) {
      for ($i = 0; $i < count($venue_equipments); $i++) {
        $equipments_total =
          $equipments_total +
          ($venue_equipments[$i]->price)
          * ($selected_equipments[$i]);
        if ($selected_equipments[$i] != 0) {
          $selected_e_item = $venue_equipments[$i]->item;
          $selected_e_price = $venue_equipments[$i]->price;
          $selected_e_count = $selected_equipments[$i];
          $equipments_details[] = [$selected_e_item, $selected_e_price, $selected_e_count];
        }
      }
    }
    // サービス料金×個数
    $venue_services = $this->services()->get();
    $services_total = 0;
    $services_details = [];
    if (!empty($selected_services)) {
      for ($ii = 0; $ii < count($venue_services); $ii++) {
        $services_total =
          $services_total
          + ($venue_services[$ii]->price)
          * ($selected_services[$ii]);
        if ($selected_services[$ii] != 0) {
          // ※注意　ここでherokuにてエラーがでている
          $selected_s_item = $venue_services[$ii]->item;
          $selected_s_price = $venue_services[$ii]->price;
          $selected_s_count = $selected_services[$ii];
          $services_details[] = [$selected_s_item, $selected_s_price, $selected_s_count];
        }
      }
    }

    $total_items_price = $equipments_total + $services_total; //備品＆サービス合計金額
    return [
      $total_items_price,
      $equipments_details,
      $services_details,
      $equipments_total,
      $services_total
    ];
  }

  public function getLayoutPrice($prepare, $clean)
  {
    $prepare_result = '';
    $clean_result = '';
    $total = '';
    $prepare == 1 ? $prepare_result = $this->layout_prepare : $prepare_result = 0;
    $clean == 1 ? $clean_result = $this->layout_clean : $clean_result = 0;
    $total = $prepare_result + $clean_result;
    return [$prepare_result, $clean_result, $total];
  }

  public static function getBreakdowns($request)
  {
    $venue_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/venue_breakdown_item/', $key)) {
        $venue_details[] = $value;
      }
    }
    return count($venue_details);
  }

  public function getPriceSystem()
  {
    $frame = 0;
    $time = 0;
    if ($this->frame_prices->count() != 0) {
      $frame = 1;
    }
    if ($this->time_prices->count() != 0) {
      $time = 1;
    }
    return [$frame, $time];
  }

  public function getCostForPartner($venue, $total, $layout, $reservation) //提携会場が選択された際の売上請求情報一覧に表示する原価
  {
    if ($venue->alliance_flag == 0) {
      return 0;
    } else {
      $percent = ($reservation->cost) * 0.01;
      // dump('total', $total);
      // dump('percent', $percent);
      // dump('layout', $layout);
      return ($total - ($layout * 1.1)) * $percent;
    }
  }

  public function getProfitForPartner($venue, $total, $layout, $reservation) //提携会場が選択された際の売上請求情報一覧に表示する原価
  {
    if ($venue->alliance_flag == 0) {
      return $total;
    } else {
      $cost = $this->getCostForPartner($venue, $total, $layout, $reservation);
      return $total - $cost;
    }
  }
}
