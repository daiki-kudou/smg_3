<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Jobs\Reservation\MailForReservationAfterDblCheck;
use App\Jobs\Reservation\MailForPreReservationAfterAdminEdit;
use App\Jobs\Reservation\MailForReservationAfterSwitchedByUser;
use App\Jobs\Reservation\MailForBillAfterDblCheckAddBill;
use App\Jobs\Reservation\MailForBillAfterUserApproveAddBill;
use App\Jobs\Reservation\MailForReservationRequestFromUser;
use App\Jobs\Reservation\MailForUserAfterCheckPaid;
use App\Jobs\Reservation\MailForUserCxlAfterDblCheck;
use App\Jobs\Reservation\MailForCxlAfterUserCheck;
use App\Jobs\Reservation\MailForUserAfterCheckCxlPaid;
use App\Jobs\Reservation\MailForConfirmReservation;
use App\Jobs\Reservation\MailForDeletePreReservation;
use App\Jobs\Reservation\MailForDeleteReservation;
use App\Jobs\Cron\CronForPayDayFiveDaysLeft;
use App\Jobs\Cron\CronPayDayTwoDaysLeft;
use App\Jobs\Auth\MailForRegister;
use App\Jobs\Auth\MailForRegisterComplete;
use App\Jobs\Auth\MailForUnSub;


class SendSMGEmail
{
  // /**  
  //  * 入金ステータスが1なら入金完了メールを送る    
  //  * @param object $user ユーザーの配列データ   
  //  * @param object $reservation 予約のオブジェクト   
  //  * @param object $venue 会場オブジェクト   
  //  */

  // public function __construct($data)
  // {
  //   $this->data = $data;
  // }

  public function send($condition, $data)
  {
    switch ($condition) {
        // 【2】-1｜仮押え・承認依頼
      case "管理者仮押え完了及びユーザーへ編集権限譲渡":
        MailForPreReservationAfterAdminEdit::dispatch($data);
        break;
        // 【2】-2｜仮押え・取消し
      case "管理者が仮抑え一覧よりチェックボックスを選択し削除":
        MailForDeletePreReservation::dispatch($this->user, $this->reservation, $this->venue);
        break;

        // 【3】-1｜予約受付完了
      case "管理者主導仮押えから本予約切り替え（ユーザー承認）":
        MailForReservationAfterSwitchedByUser::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【3】-1｜予約受付完了
      case "ユーザーからの予約依頼受付":
        MailForReservationRequestFromUser::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【3】-2｜予約・承認依頼（追加請求含）
      case "管理者ダブルチェック完了後、ユーザーへ承認依頼を送付":
        MailForReservationAfterDblCheck::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【3】-2｜予約・承認依頼（追加請求含）
      case "予約内容追加。管理者からユーザーへ承認依頼を送付":
        MailForBillAfterDblCheckAddBill::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【3】-3｜予約・予約完了
      case "予約完了":
        MailForConfirmReservation::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【3】-3｜予約・予約完了
      case "ユーザーが追加予約の承認完了後、メール送信":
        MailForBillAfterUserApproveAddBill::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【3】-4｜予約・予約取消
      case "管理者が詳細画面にて予約を削除":
        MailForDeleteReservation::dispatch($this->user, $this->reservation, $this->venue);
        break;

        // 【4】-1｜キャンセル・承認依頼
      case "管理者ダブルチェック完了後、キャンセル承認メールをユーザーへ送付":
        MailForUserCxlAfterDblCheck::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【4】-2｜キャンセル・キャンセル完了
      case "ユーザーがキャンセルを承認":
        MailForCxlAfterUserCheck::dispatch($this->user, $this->reservation, $this->venue);
        break;

        // 【5】-3｜入金完了
      case "入金ステータスを入金済みに更新":
        MailForUserAfterCheckPaid::dispatch($this->user, $this->reservation, $this->venue);
        break;
        // 【5】-3｜入金完了
      case "キャンセル料入金確認完了":
        MailForUserAfterCheckCxlPaid::dispatch($this->user, $this->reservation, $this->venue);
        break;






      default:
        break;
    }
  }

  /**
   * クーロン用送信dispatch
   *
   * @param string $condition
   * @return void
   */
  public function CronSend($condition)
  {
    switch ($condition) {
      case "入金期日5営業日前(催促)":
        CronForPayDayFiveDaysLeft::dispatch($this->user, $this->reservation, $this->venue);
        break;

      case "入金期日2営業日前(催促)":
        CronPayDayTwoDaysLeft::dispatch($this->user, $this->reservation, $this->venue);
        break;

      default:
        break;
    }
  }

  /**
   * auth用送信dispatch
   *
   * @param string $condition
   * @return void
   */
  public function AuthSend($condition)
  {
    switch ($condition) {
      case "ユーザー会員登録用、認証メール送信":
        MailForRegister::dispatch($this->user, $this->reservation, $this->venue);
        break;

      case "ユーザー会員登録用成功":
        MailForRegisterComplete::dispatch($this->user, $this->reservation, $this->venue);
        break;

      case "退会":
        MailForUnSub::dispatch($this->user, "", "");
        break;


      default:
        break;
    }
  }
}
