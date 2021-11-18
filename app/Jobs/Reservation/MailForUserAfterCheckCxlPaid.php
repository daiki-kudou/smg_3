<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Models\Cxl;
use App\Mail\UserCxlPaid;
use App\Mail\FailedMail;
use Mail;
use Carbon\Carbon;


class MailForUserAfterCheckCxlPaid implements ShouldQueue
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
    $cxl_data = $this->adjustCxlData();
    $subject = "【会議室お支払｜[売上請求情報：キャンセル]：" . $reservation_data->reservation_id . "】入金完了のお知らせ（SMG貸し会議室）";
    Mail::to($reservation_data->user_email)
      ->send(new UserCxlPaid(
        $reservation_data,
        $cxl_data,
        $subject
      ));
  }

  public function adjustReservationData()
  {
    $reservation = new Reservation();
    return $reservation->ReservationEmailTemplate($this->data['reservation_id']);
  }

  public function adjustCxlData()
  {
    $cxl = new Cxl;
    return $cxl->CxlEmailTemplate($this->data['cxl_id']);
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
