<?php

namespace App\Jobs\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use App\Mail\AdminFinLeg;
use App\Mail\UserFinLeg;
use Mail;

class MailForRegisterComplete implements ShouldQueue
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
    // $admin = config('app.admin_email');
    // Mail::to($admin)
    //   ->send(new AdminFinLeg(
    //     $this->user,
    //   ));
    Mail::to($this->params['user']->email)
      ->send(new UserFinLeg(
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
    // メール自体は送信できる
    // 失敗用の文面を用意する必要あり
    // $admin = config('app.admin_email');
    // Mail::to($admin)->send(new AdminFinDblChk([(string)$exception]));
  }
}
