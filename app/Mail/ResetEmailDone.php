<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class ResetEmailDone extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($template_id, $company)
	{
		$this->template_id = $template_id;
		$this->company = $company;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.resetEmailDone')
		// 	->subject('メールアドレス変更完了のお知らせ（SMG貸し会議室）')
		// 	->with([
		// 		'company' => $this->data->company,
		// 	]);
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$send_html = str_replace('${compny}', $this->company, $body);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.resetEmailDone')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
