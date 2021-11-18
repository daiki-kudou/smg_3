<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Cxl;
use App\Mail\UserFinCxl;
use App\Mail\FailedMail;

use Mail;

class MailForCxlAfterUserCheck implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $cxl_id;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($cxl_id)
  {
    $this->cxl_id = $cxl_id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $admin = config('app.admin_email');
    $cxl_data = $this->adjustCxlData();
    $subject = "【会議室｜キャンセル：" . $cxl_data->reservation_id . "】手続き完了/お支払のお知らせ（SMG貸し会議室）";
    Mail::to($cxl_data->user_email)
      ->cc($admin)
      ->send(new UserFinCxl(
        $cxl_data,
        $subject,
      ));
  }

  public function adjustCxlData()
  {
    $cxl = new Cxl();
    return $cxl->CxlEmailTemplate($this->cxl_id);
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
