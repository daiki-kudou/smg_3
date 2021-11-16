<?php

namespace App\Jobs\Cron;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\PayDayTwoDaysLeft;
use Mail;

class CronPayDayTwoDaysLeft implements ShouldQueue
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
    $subject = "【会議室お支払｜[売上請求情報：" . $this->data['data']->category . "]：" . $this->data['data']->reservation_id . "】" . $this->data['title'] . "のお知らせ（SMG貸し会議室）";
    Mail::to($this->data['data']->user_email)
      ->cc($admin)
      ->send(new PayDayTwoDaysLeft(
        $this->data['data'],
        $subject
      ));
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
