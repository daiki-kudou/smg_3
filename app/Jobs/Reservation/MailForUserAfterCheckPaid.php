<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Models\Bill;
use App\Mail\UserPaid;
use Mail;

class MailForUserAfterCheckPaid implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $data;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $admin = config('app.admin_email');
    $reservation_data = $this->adjustReservationData();
    $bill_data = $this->adjustBillData();
    $subject = "【会議室お支払｜[売上請求情報：" . $this->data['bill_or_add_bill'] . "]：" . $reservation_data->reservation_id . "】入金完了のお知らせ（SMG貸し会議室）";
    Mail::to($reservation_data->user_email)
      ->cc($admin)
      ->send(new UserPaid(
        $reservation_data,
        $bill_data,
        $subject,
        $this->data['bill_or_add_bill'] //会場予約or追加請求　（文字列でくる）
      ));
  }

  public function adjustReservationData()
  {
    $reservation = new Reservation();
    return $reservation->ReservationEmailTemplate($this->data['reservation_id']);
  }

  public function adjustBillData()
  {
    $bill = new Bill;
    return $bill->BillEmailTemplate($this->data['bill_id']);
  }

  /**
   * 失敗したジョブの処理
   *
   * @param  Exception  $exception
   * @return void
   */
  public function failed($exception)
  {
  }
}
