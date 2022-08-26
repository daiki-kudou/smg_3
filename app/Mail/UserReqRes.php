<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Consts\MailTemplateConst;
use App\Models\MailTemplate;

class UserReqRes extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($data, $subject, $master_total)
	{
		$this->template_id = MailTemplateConst::RESERVATION_REQUEST;

		$this->data = $data;
		$this->subject = $subject;
		$this->master_total = $master_total;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.userReqRes')
		// 	->subject($this->subject)
		// 	->with([
		// 		'company' => $this->data->company,
		// 		'reservation_id' => $this->data->reservation_id,
		// 		'reserve_date' => $this->data->reserve_date,
		// 		'user_id' => $this->data->user_id,
		// 		'enter_time' => $this->data->enter_time,
		// 		'leave_time' => $this->data->leave_time,
		// 		'venue_name' => $this->data->venue_name,
		// 		'smg_url' => $this->data->smg_url,
		// 		'master_total' => $this->master_total,
		// 	]);
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$subtitle = str_replace('${reservation_id}', $this->data->reservation_id, $subtitle);

		$send_html = str_replace('${company}', $this->data->company, $body);
		$send_html = str_replace('${reservation_id}', $this->data->reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $this->data->reserve_date, $send_html);
		$send_html = str_replace('${user_id}', $this->data->user_id, $send_html);
		$send_html = str_replace('${enter_time}', $this->data->enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $this->data->leave_time, $send_html);
		$send_html = str_replace('${venue_name}', $this->data->venue_name, $send_html);
		$send_html = str_replace('${smg_url}', $this->data->smg_url, $send_html);
		$send_html = str_replace('${master_total}', $this->master_total, $send_html);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.userReqRes')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
