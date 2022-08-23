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
		$reservations = $this->masterQuery();
		foreach ($reservations as $key => $value) {
			$status = explode(',', $value->reservation_status);
			$skip = false;
			foreach ($status as $s_value) {
				if ($s_value > 3) {
					$skip = true;
				}
			}
			if (!$skip) {
				$SendSMGEmail = new SendSMGEmail();
				$SendSMGEmail->CronSend(
					"お礼メール",
					[
						'email' => $value->user_email,
						'company' => $value->company
					]
				);
			}
		}
	}

	public function masterQuery()
	{
		$reservations = DB::table('reservations')
			->select(DB::raw(
				"
        reservations.id as reservation_id,
        GROUP_CONCAT(DISTINCT bills.reservation_status) as reservation_status,
        users.company as company,
        users.email as user_email
        "
			))
			->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
			->leftJoin('users', 'reservations.user_id', '=', 'users.id')
			->whereRaw('email_flag = 1')
			->whereRaw('users.id > 0')
			->whereRaw("reservations.reserve_date = (DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY), '%Y-%m-%d'))")
			->whereRaw('reservations.deleted_at is null')
			->groupByRaw('reservations.id')
			->get();

		return $reservations;
	}
}
