<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    Commands\CommandCronPayDayTwoDaysLeft::Class,
    Commands\CommandCronThanks::Class,
    Commands\CommandPayDayOverLimit::Class,
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    // クーロン実際の処理
    $schedule->command('command:cron_pay_day_two_days_left')->dailyAt('11:00'); //入金2営業日前　催促
    $schedule->command('command:thanks')->dailyAt('16:00'); //入金2営業日前　催促
    $schedule->command('command:cron_pay_day_over_limit')->dailyAt('13:00'); //入金超過

    // バックアップ
    $schedule->command('php artisan backup:clean --disable-notifications')->dailyAt('04:00');
    $schedule->command('php artisan backup:run --disable-notifications --only-db')->dailyAt('04:00');
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
