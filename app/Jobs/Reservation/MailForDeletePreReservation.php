<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PreReservation;
use App\Mail\UserPreResCxl;
use App\Mail\FailedMail;
use Carbon\Carbon;
use Mail;

class MailForDeletePreReservation implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $id;

  /**
   * Create a new job instance.
   *
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
    $subject = "【仮押え：" . $data->pre_reservation_id . "】取消しのお知らせ（SMG貸し会議室）";
    Mail::to($data->user_email)
      ->cc($admin)
      ->send(new UserPreResCxl(
        $data,
        $subject
      ));

    $this->deleteData();
  }

  public function adjustData()
  {
    $pre_reservation = new PreReservation();
    return $pre_reservation->PreReservationEmailTemplate($this->id);
  }

  public function deleteData()
  {
    $preReservation = PreReservation::find($this->id);
    $preReservation->delete();
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
