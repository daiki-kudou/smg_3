<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon; //carbon利用


class Venue extends Model
{

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

  public function searchs(
    $freeword,
    $id,
    $alliance_flag,
    $name_area,
    $name_bldg,
    $name_venue,
    $capacity1,
    $capacity2,
    $counter
  ) {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('alliance_flag', 'LIKE', "%$freeword%")
        ->orWhere('name_area', 'LIKE', "%$freeword%")
        ->orWhere('alliance_flag', 'LIKE', "%$freeword%")
        ->orWhere('name_bldg', 'LIKE', "%$freeword%")
        ->orWhere('name_venue', 'LIKE', "%$freeword%")
        ->orWhere('capacity', 'LIKE', "%$freeword%")
        ->orWhere('capacity', 'LIKE', "%$freeword%")->paginate($counter);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate($counter);
    } else if (isset($alliance_flag)) {
      return $this->where('alliance_flag', 'LIKE', "%$alliance_flag%")->paginate($counter);
    } else if (isset($name_area)) {
      return $this->where('name_area', 'LIKE', "%$name_area%")->paginate($counter);
    } else if (isset($name_bldg)) {
      return $this->where('name_bldg', 'LIKE', "%$name_bldg%")->paginate($counter);
    } else if (isset($name_venue)) {
      return $this->where('name_venue', 'LIKE', "%$name_venue%")->paginate($counter);
    } else if (isset($capacity1) && isset($capacity2)) {
      return $this->whereBetween('capacity', $capacity1, $capacity2)->paginate($counter);;
    } else if (isset($capacity1)) {
      return $this->where('capacity', '>=', $capacity1)->paginate($counter);;
    } else if (isset($capacity2)) {
      return $this->where('capacity', '<=', $capacity2)->paginate($counter);;
    } else {
      return $this->query()->paginate($counter);
    }
  }

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
    return $this->hasMany(Frame_price::class);
  }

  /*
|--------------------------------------------------------------------------
| 時間貸し料金と会場の一対多
|--------------------------------------------------------------------------|
*/
  public function time_prices()
  {
    return $this->hasMany(Time_price::class);
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
| 会場と仲介会社の多対多
|--------------------------------------------------------------------------|
*/
  // public function agents()
  // {
  //   return $this->belongsToMany('App\Models\Agent')->withTimestamps();
  // }


  /*
|--------------------------------------------------------------------------
| 会場の料金計算
|--------------------------------------------------------------------------|
*/
  public function calculate_price($status_id, $start_time, $finish_time)
  {
    if ($status_id == 1) {

      //料金計算に使う開始時間を計算用に変更
      // 開始時間
      if ($start_time >= '10:00:00' && $start_time <= '19:00:00') {
        $generate_start_time = $start_time;
      } else if ($start_time == '08:00:00' || $start_time == '08:30:00' || $start_time == '09:00:00' || $start_time == '09:30:00') {
        $generate_start_time = '10:00:00';
      }

      //料金計算に使う開始時間を計算用に変更
      // 開始時間
      if ($start_time == '17:00:00' || $start_time == '17:30:00') {
        $generate_start_time = '18:00:00';
      } else if ($start_time == '12:00:00' || $start_time == '12:30:00') {
        $generate_start_time = '13:00:00';
      }

      //料金計算に使う開始時間を計算用に変更
      // 終了時間
      if ($finish_time <= '22:00:00') {
        $generate_finish_time = $finish_time;
      } else if ($finish_time == '22:30:00' || $finish_time == '23:00:00') {
        $generate_finish_time = '22:00:00';
      }

      $price_arrays = $this->frame_prices()->get(); //料金体系判別　and　料金抽出
      $start_array = [];
      $finish_array = [];
      foreach ($price_arrays as $price_array) {
        $start_array[] = $price_array->start;
        $finish_array[] = $price_array->finish;
      }

      $between_time = [];
      for ($i = 0; $i < count($start_array); $i++) {
        $between_time[] = [$start_array[$i], $finish_array[$i]];
      }

      $between_time_list = []; //全料金パターンの時間配列が入ってる
      $temporary = []; //一時的にパターン毎の料金配列が入ってる

      for ($pushes = 0; $pushes < count($between_time); $pushes++) { //0から6
        $get_event_time_start = intval($between_time[$pushes][0]);
        $get_event_time_end = intval($between_time[$pushes][1]);

        for ($lists = $get_event_time_start * 2; $lists <= $get_event_time_end * 2; $lists++) {
          $temporary[] = date("H:i:s", strtotime("00:00 +" . $lists * 30 . " minute"));
        }
        $between_time_list[] = $temporary;
        $temporary = []; //temporaryに配列挿入後、一旦初期化
      }

      /*|--------------------------------------------------------------------------
      |↓↓↓ 一旦ここで、網羅できる料金体系を抽出完了↓↓↓
      |--------------------------------------------------------------------------|*/
      $cover_price_result = []; //網羅できる料金体系が格納される
      for ($price_results = 0; $price_results < count($price_arrays); $price_results++) {
        // 以下、枠が開始・終了をカバーできるか判定
        $judge_start = in_array($generate_start_time, $between_time_list[$price_results]); //開始がカバーできてるか
        $judge_finish = in_array($generate_finish_time, $between_time_list[$price_results]); //終了がカバーできてるか
        if ($judge_start && $judge_finish) {
          $cover_price_result[] = $price_arrays[$price_results];
        } else {
          $cover_price_result[] = 'false';
        }
      }
      /*|--------------------------------------------------------------------------
      | ↑↑↑一旦ここで、網羅できる料金体系を抽出完了↑↑↑
      |--------------------------------------------------------------------------|*/

      // 延長料金を適応して、料金算出できるか判定
      $extend_lists = []; //延長可能な料金体系のindexと実際に延長する時間が配列で入ってる
      for ($judge_extend = 0; $judge_extend < count($price_arrays); $judge_extend++) {
        // 以下、枠に延長を足したらカバーできるか判定
        $judge_start_extend = in_array($generate_start_time, $between_time_list[$judge_extend]); //開始がカバーできてるか
        $judge_finish_extend = in_array($generate_finish_time, $between_time_list[$judge_extend]); //終了がカバーできてるか
        if ($judge_start_extend && !$judge_finish_extend) {
          // return "開始はカバーOK,終了は無理";
          $selected_finish = strtotime($generate_finish_time);
          $specific_finish = strtotime($price_arrays[$judge_extend]->finish);
          $extend_lists[] = ($selected_finish - $specific_finish) / 60 / 60;
        } else {
          $extend_lists[] = 'false';
        }
      }
      $extend_prices = []; //1時間もしくは30分の延長料金が入ってる
      foreach ($extend_lists as $extend_list_index => $extend_list_price) {
        if ($extend_list_price == 1) {
          $extend_prices[] = $price_arrays[0]->extend;
        } else if ($extend_list_price == 0.5) {
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
        } else if ($cover_price_result[$extend_final] != 'false') {
          $extend_final_prices[] = $price_arrays[$extend_final]->price;
        } else {
          $extend_final_prices[] = null;
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
      $min_result = min($min_results);

      // 延長料金抽出
      $exted_specific_price = $extend_prices[array_search($min_result, $extend_final_prices)];
      if ($exted_specific_price != 'false') {
        $exted_specific_price;
      } else if ($exted_specific_price == 'false') {
        $exted_specific_price = 0;
      }
      // 延長料金抽出

      // 8時例外：8時から10時を選択すると時間に応じて延長料金適応
      if ($start_time == '08:00:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 2;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 2;
      } else if ($start_time == '08:30:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 1.5;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1.5;
      } else if ($start_time == '09:00:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 1.0;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1.0;
      } else if ($start_time == '09:30:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 0.5;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 0.5;
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

      if ($start_time == '12:00:00') {
        $min_result = $min_result + ($price_arrays[0]->extend) * 1;
        $exted_specific_price = $exted_specific_price + ($price_arrays[0]->extend) * 1;
      } else if ($start_time == '12:30:00') {
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
      return [$min_result, $exted_specific_price, $time_diff, $extend_diff];

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

        return [$time_min_result, $specific_extend_timeprice, $specific_extend_time, $specific_extend_time];
      } else {
        return fail;
      }
    }
  }

  public function calculate_items_price($selected_equipments, $selected_services)
  {
    // 備品料金×個数
    $venue_equipments = $this->equipments()->get();
    $equipments_total = 0;
    $equipments_details = [];
    for ($i = 0; $i < count($venue_equipments); $i++) {
      $equipments_total = $equipments_total + ($venue_equipments[$i]->price) * ($selected_equipments[$i]);
      if ($selected_equipments[$i] != 0) {
        $selected_e_item = $venue_equipments[$i]->item;
        $selected_e_price = $venue_equipments[$i]->price;
        $selected_e_count = $selected_equipments[$i];
        $equipments_details[] = [$selected_e_item, $selected_e_price, $selected_e_count];
      }
    }
    // サービス料金×個数
    $venue_services = $this->services()->get();
    $services_total = 0;
    $services_details = [];
    for ($ii = 0; $ii < count($venue_services); $ii++) {
      $services_total =
        $services_total
        + ($venue_services[$ii]->price)
        * ((int)$selected_services[$ii]);
      if ($selected_services[$ii] != 0) {
        $selected_s_item = $venue_services[$ii]->item;
        $selected_s_price = $venue_services[$ii]->price;
        $selected_s_count = $selected_services[$ii];
        $services_details[] = [$selected_s_item, $selected_s_price, $selected_s_count];
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
}
