<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Http\Helpers\ReservationHelper;
use App\Http\Helpers\ImageHelper;
use App\Models\Reservation;
use DB;


class CustomDataTable
{

  /** 予約一覧表示のための成形
   * @param object $data   予約一覧表示用の collection
   * @return string 一覧表示用のjsonデータ
   */
  public function ReservationFormat($data)
  {
    $c_reservations = [];
    foreach ($data as $key => $r) {
      if ($key === 100) {
        break;
      }
      // 配列に格納 ※連想配列にすると上手く動かなくなるので配列にする
      $c_reservations[] = [
        $r->id, //予約ID
        ReservationHelper::formatDate($r->reserve_date), //利用日
        ReservationHelper::formatTime($r->enter_time), //入室
        ReservationHelper::formatTime($r->leave_time), //退室
        $r->venue_name, //利用会場
        $r->company, //会社名団体名
        $r->user_name, //担当者氏名
        $r->mobile, //携帯電話
        $r->tel, //固定電話
        "", //仲介会社
        "", //エンドユーザー
        "", //アイコン
        $this->ReservationStatus($r->id), //売上区分
        "予約状況", //予約状況
        "予約詳細", //予約詳細
        "案内板", //案内板
      ];
    }
    return  json_encode($c_reservations);
  }
}
