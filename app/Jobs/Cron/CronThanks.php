<?php

namespace App\Jobs\Cron;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Thanks;
use App\Mail\FailedMail;
use Carbon\Carbon;
use Mail;

class CronThanks implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $data;

	/**
	 * Create a new job instance.
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
		$subject = "会議室ご利用の御礼（SMG貸し会議室）";
		Mail::to($this->data['email'])
			->send(new Thanks($this->data['company'], $subject));
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
