<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Jobs\MailForReservationAfterDblCheck;


class SendSMGEmail
{
  /**   * 
   * 入金ステータスが1なら入金完了メールを送る   *   * 
   * @param object $user ユーザーの配列データ   * 
   * @param object $reservation 予約のオブジェクト   
   * @param object $venue 会場オブジェクト   
   * */

  public function __construct($user, $reservation, $venue)
  {
    $this->user = $user;
    $this->reservation = $reservation;
    $this->venue = $venue;
  }

  public function send($condition)
  {
    switch ($condition) {
      case "管理者ダブルチェック完了後、ユーザーへ承認依頼を送付":
        MailForReservationAfterDblCheck::dispatch($this->user, $this->reservation, $this->venue);
        break;

      default:
        # code...
        break;
    }
  }
}
