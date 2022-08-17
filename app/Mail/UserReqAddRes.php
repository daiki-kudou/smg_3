<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Consts\MailTemplateConst;
use App\Models\MailTemplate;

class UserReqAddRes extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($data, $subject, $master_total, $bill_id, $category)
	{
		$this->template_id = MailTemplateConst::RESERVATION_APPROVE;

		$this->data = $data;
		$this->subject = $subject;
		$this->master_total = $master_total;
		$this->bill_id = $bill_id;
		$this->category = $category;
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

		$subtitle = str_replace('${category}', $this->category, $subtitle);
		$subtitle = str_replace('${reservation_id}', $this->data->reservation_id, $subtitle);

		$send_html = str_replace('${company}', $this->data->company, $body);
		$send_html = str_replace('${category}', $this->category, $send_html);
		$send_html = str_replace('${reservation_id}', $this->data->reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $this->data->reserve_date, $send_html);
		$send_html = str_replace('${user_id}', $this->data->user_id, $send_html);
		$send_html = str_replace('${enter_time}', $this->data->enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $this->data->leave_time, $send_html);
		$send_html = str_replace('${venue_name}', $this->data->venue_name, $send_html);
		$send_html = str_replace('${smg_url}', $this->data->smg_url, $send_html);
		$send_html = str_replace('${master_total}', $this->master_total, $send_html);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.userReqAddRes')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
