<?php

namespace App\Jobs\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ResetEmailDone;
use App\Mail\FailedMail;

use Mail;

class UpdateUserMailAddressDone implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $data;

  /**
   * Create a new job instance.
   * 
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
    Mail::to($this->data->email)
      ->send(new ResetEmailDone(
        $this->data,
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
