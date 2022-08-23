<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class UserUnSub extends Mailable
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
		// return $this->view('maileclipse::templates.userUnSub')
		//   ->subject($this->subject)
		//   ->with(['user' => $this->user]);
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$send_html = str_replace('${company}', $this->company, $body);

		return $this->view('maileclipse::templates.userUnSub')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
