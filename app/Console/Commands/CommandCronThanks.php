<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Service\SendSMGEmail;
use Carbon\Carbon;
use DB;


class CommandCronThanks extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'command:thanks';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '送信用コマンド：お礼メール';

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
    //
  }
}
