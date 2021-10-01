<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Jobs\Reservation\MailForReservationAfterDblCheck;
use App\Jobs\Reservation\MailForPreReservationAfterAdminEdit;
use App\Jobs\Reservation\MailForReservationAfterSwitchedByUser;
use App\Jobs\Reservation\MailForBillAfterDblCheckAddBill;
use App\Jobs\Reservation\MailForBillAfterUserApproveAddBill;


class SendSMGEmail
{
  /**  
   * 入金ステータスが1なら入金完了メールを送る    
   * @param object $user ユーザーの配列データ   
   * @param object $reservation 予約のオブジェクト   
   * @param object $venue 会場オブジェクト   
   */

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

      case "管理者仮押え完了及びユーザーへ編集権限譲渡":
        MailForPreReservationAfterAdminEdit::dispatch($this->user, $this->reservation, $this->venue);
        break;

      case "管理者主導仮押えから本予約切り替え（ユーザー承認）":
        MailForReservationAfterSwitchedByUser::dispatch($this->user, $this->reservation, $this->venue);
        break;

      case "予約内容追加。管理者からユーザーへ承認依頼を送付":
        MailForBillAfterDblCheckAddBill::dispatch($this->user, $this->reservation, $this->venue);
        break;

      case "ユーザーが追加予約の承認完了後、メール送信":
        MailForBillAfterUserApproveAddBill::dispatch($this->user, $this->reservation, $this->venue);
        break;

      default:
        # code...
        break;
    }
  }
}
