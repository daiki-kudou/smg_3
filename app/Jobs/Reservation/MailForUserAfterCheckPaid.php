<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AdminPaid;
use App\Mail\UserPaid;
use Mail;

class MailForUserAfterCheckPaid implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $user;
  public $reservation;
  public $venue;

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
      ->send(new AdminPaid(
        $this->user,
        $this->reservation,
        $this->venue
      ));
    Mail::to($this->user->email)
      ->send(new UserPaid(
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
  }
}
