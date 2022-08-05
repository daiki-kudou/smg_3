<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class UserReqLeg extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($template_id, $register_confirm_link)
	{
		$this->template_id = $template_id;
		$this->register_confirm_link = $register_confirm_link;
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$send_html = str_replace('${register_confirm_link}', $this->register_confirm_link, $body);
		$send_html = str_replace('${register}', url('user/preusers'), $send_html);

		return $this->view('maileclipse::templates.userReqLeg')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
