<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AdminFinDblChk;
use App\Mail\UserFinDblChk;
use Mail;



class MailForReservationAfterDblCheck implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  public $data;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($user, $reservation, $venue)
  {
    $this->user = $user;
    $this->reservation = $reservation;
    $this->venue = $venue;
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
      ->send(new AdminFinDblChk(
        $this->user,
        $this->reservation,
        $this->venue
      ));
    Mail::to($this->user->email)
      ->send(new UserFinDblChk(
        $this->user,
        $this->reservation,
        $this->venue
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
