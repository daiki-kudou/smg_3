<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class ResetPasswordEmail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($template_id, $company, $link)
	{
		$this->template_id = $template_id;
		$this->company = $company;
		$this->link = $link;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.resetPasswordEmail')
		//   ->subject("パスワード変更のご確認（SMG貸し会議室）")
		//   ->with([
		// 	    'send_html' => 'hoge',
		    
		//   ]);
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;
		
		$send_html = str_replace('${company}', $this->company, $body);
		$send_html = str_replace('${link}', $this->link, $send_html);
		$send_html = str_replace('${reset_password}', url('/user/password/reset'), $send_html);
		
		return $this->view('maileclipse::templates.resetEmail')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
