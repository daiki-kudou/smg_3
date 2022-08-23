<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class UserPreResCxl extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(
		$template_id,
		$company,
		$pre_reservation_id,
		$reserve_date,
		$enter_time,
		$leave_time,
		$venue_name,
		$smg_url
	) {
		$this->template_id = $template_id;
		$this->company = $company;
		$this->pre_reservation_id = $pre_reservation_id;
		$this->reserve_date = $reserve_date;
		$this->enter_time = $enter_time;
		$this->leave_time = $leave_time;
		$this->venue_name = $venue_name;
		$this->smg_url = $smg_url;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.userPreResCxl')
		//   ->subject($this->subject)
		//   ->with([
		//     'company' => $this->data->company,
		//     'pre_reservation_id' => $this->data->pre_reservation_id,
		//     'reserve_date' => $this->data->reserve_date,
		//     'enter_time' => $this->data->enter_time,
		//     'leave_time' => $this->data->leave_time,
		//     'venue_name' => $this->data->venue_name,
		//     'smg_url' => $this->data->smg_url
		//   ]);
		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$subtitle = str_replace('${pre_reservation_id}', $this->pre_reservation_id, $subtitle);

		$send_html = str_replace('${company}', $this->company, $body);
		$send_html = str_replace('${pre_reservation_id}', $this->pre_reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $this->reserve_date, $send_html);
		$send_html = str_replace('${enter_time}', $this->enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $this->leave_time, $send_html);
		$send_html = str_replace('${venue_name}', $this->venue_name, $send_html);
		$send_html = str_replace('${smg_url}', $this->smg_url, $send_html);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.userPreResCxl')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
