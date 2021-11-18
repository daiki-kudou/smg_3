<?php

namespace App\Jobs\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\UserReqLeg;
use App\Mail\FailedMail;
use Mail;

class MailForRegister implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $params;

  /**
   * Create a new job instance.
   * 形のために引数が3つあるが、実際は$userしか使っていない
   *
   * @return void
   */
  public function __construct($params)
  {
    $this->params = $params;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Mail::to($this->params['result']->email)
      ->send(new UserReqLeg(
        $this->params,
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
