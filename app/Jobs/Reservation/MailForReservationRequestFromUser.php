<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Models\Bill;
use App\Mail\UserReqRes;
use App\Mail\FailedMail;
use Mail;
use Carbon\Carbon;


class MailForReservationRequestFromUser implements ShouldQueue
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
    $data = $this->adjustReservationData();
    $subject = "【会議室｜[予約情報：会場予約]：" . $data->reservation_id . "】予約申込みを受付しました（SMG貸し会議室）";
    $master_total = $this->adjustBillData();
    Mail::to($data->user_email)
      ->cc($admin)
      ->send(new UserReqRes(
        $data,
        $subject,
        $master_total
      ));
  }

  public function adjustReservationData()
  {
    $reservation = new Reservation();
    return $reservation->ReservationEmailTemplate($this->data['reservation_id']);
  }

  public function adjustBillData()
  {
    $bill = Bill::find($this->data['bill_id']);
    return number_format($bill->master_total);
  }


  /**
   * 失敗したジョブの処理
   *
   * @param  Exception  $exception
   * @return void
   */
  public function failed($exception)
  {
    $admin = config('app.admin_email');
    $class_name = get_class($this);
    $time = Carbon::now();
    Mail::to($admin)
      ->send(new FailedMail($exception, $class_name, $time));
  }
}
