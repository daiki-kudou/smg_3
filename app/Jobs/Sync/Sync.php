<?php

namespace App\Jobs\Sync;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SSH;


class Sync implements ShouldQueue
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
  public function __construct()
  {
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $sync = SSH::run([
      'cd /webtrickster/public_html/osaka-conference.com',
      'rsync -avz --exclude="smg_0621.sql" --exclude="SMG" --exclude="MT6" -e "ssh -i /webtrickster/public_html/system.osaka-conference.com.pem" ../osaka-conference.com/system.osaka-conference.com@3.112.120.173:/home/system.osaka-conference.com/public_html/'
    ]);
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
