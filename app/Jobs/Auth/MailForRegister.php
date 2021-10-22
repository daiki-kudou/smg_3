<?php

namespace App\Jobs\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AdminReqLeg;
use App\Mail\UserReqLeg;
use Mail;

class MailForRegister implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $user;
  public $reservation;
  public $venue;

  /**
   * Create a new job instance.
   * 形のために引数が3つあるが、実際は$userしか使っていない
   *
   * @return void
   */
  public function __construct($user, $reservation, $venue)
  {
    $this->user = $user;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $admin = config('app.admin_email');
    Mail::to($admin)
      ->send(new AdminReqLeg(
        $this->user,
      ));
    Mail::to($this->user['result']->email)
      ->send(new UserReqLeg(
        $this->user,
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
