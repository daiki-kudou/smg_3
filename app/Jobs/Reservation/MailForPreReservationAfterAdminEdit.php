<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PreReservation;
use App\Mail\UserFinPreRes;
use Mail;

class MailForPreReservationAfterAdminEdit implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $id;

  /**
   * Create a new job instance.
   * @param int $id id番号
   * @return void
   */
  public function __construct($id)
  {
    $this->id = $id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $admin = config('app.admin_email');
    $data = $this->adjustData();
    $subject = "【仮押え：" . $data->pre_reservation_id . "】予約申込み手続きのお願い（SMG貸し会議室）";
    Mail::to($data->user_email)
      ->cc($admin)
      ->send(new UserFinPreRes(
        $data,
        $subject
      ));
  }

  public function adjustData()
  {
    $pre_reservation = new PreReservation();
    return $pre_reservation->PreReservationEmailTemplate($this->id);
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
