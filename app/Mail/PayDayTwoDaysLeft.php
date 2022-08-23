<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Helpers\ReservationHelper;
use App\Consts\MailTemplateConst;
use App\Models\MailTemplate;


class PayDayTwoDaysLeft extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($data, $subject)
	{
		$this->template_id = MailTemplateConst::REMIND_PAYDAY_2;

		$this->data = $data;
		$this->subject = $subject;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.payDayTwoDaysLeft')
		// 	->subject($this->subject)
		// 	->with([
		// 		'company' => $this->data->company,
		// 		'category' => $this->data->category,
		// 		'reservation_id' => $this->data->reservation_id,
		// 		'reserve_date' => $this->data->reserve_date,
		// 		'user_id' => $this->data->user_id,
		// 		'enter_time' => $this->data->enter_time,
		// 		'leave_time' => $this->data->leave_time,
		// 		'venue_name' => $this->data->venue_name,
		// 		'smg_url' => $this->data->smg_url,
		// 		'master_total' => $this->data->master_total,
		// 		'invoice_number' => $this->data->invoice_number,
		// 		'payment_limit' => $this->data->payment_limit,
		// 	]);
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$subtitle = str_replace('${category}', $this->data->category, $subtitle);
		$subtitle = str_replace('${reservation_id}', $this->data->reservation_id, $subtitle);

		$send_html = str_replace('${company}', $this->data->company, $body);
		$send_html = str_replace('${category}', $this->data->category, $send_html);
		$send_html = str_replace('${reservation_id}', $this->data->reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $this->data->reserve_date, $send_html);
		$send_html = str_replace('${user_id}', $this->data->user_id, $send_html);
		$send_html = str_replace('${enter_time}', $this->data->enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $this->data->leave_time, $send_html);
		$send_html = str_replace('${venue_name}', $this->data->venue_name, $send_html);
		$send_html = str_replace('${invoice_number}', $this->data->invoice_number, $send_html);
		$send_html = str_replace('${master_total}', $this->data->master_total, $send_html);
		$send_html = str_replace('${payment_limit}', $this->data->payment_limit, $send_html);
		$send_html = str_replace('${smg_url}', $this->data->smg_url, $send_html);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.payDayTwoDaysLeft')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
