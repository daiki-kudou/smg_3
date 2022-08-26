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
			$SendSMGEmail = new SendSMGEmail();
			$SendSMGEmail->CronSend(
				"お礼メール",
				[
					'email' => $value->email,
					'company' => $value->company
				]
			);
		}
	}

	public function masterQuery()
	{

		$reservations = DB::table('bills')
			->select(DB::raw("distinct users.id, users.email, users.company"))
			->leftJoin('reservations', 'bills.reservation_id', '=', 'reservations.id')
			->leftJoin('users', 'reservations.user_id', '=', 'users.id')
			->whereRaw("reservation_status = ?", [3])
			->whereRaw("reservations.email_flag = ?", [1])
			->whereRaw("reservations.reserve_date = (DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY), '%Y-%m-%d')) ")
			->whereRaw("reservations.user_id > ?", [0])
			->whereRaw("reservations.deleted_at is null")
			->get();


		return $reservations;
	}
}
