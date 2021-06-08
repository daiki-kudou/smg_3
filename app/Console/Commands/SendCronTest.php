<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\CronTest;

class SendCronTest extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  // protected $signature = 'command:name';
  protected $signature = 'app:send_notification_mail';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $to = "kudou@web-trickster.com";
    Mail::to($to)->send(new CronTest());
    \Log::info('ログ出力テスト - command');
  }
}
