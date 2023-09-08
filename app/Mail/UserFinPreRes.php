<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class UserFinPreRes extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($template_id, $prereservation, $venue)
	{
		$this->template_id = $template_id;
		$this->prereservation = $prereservation;
		$this->venue = $venue;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.userFinPreRes')
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

		$company = $this->prereservation->user->company;
		$login = url('user/login');
		$pre_reservation_id = sprintf('%06d', $this->prereservation->id);
		$reserve_date = !empty($this->prereservation->reserve_date) ? date('Y年m月d日', strtotime($this->prereservation->reserve_date)) : null;
		$enter_time = !empty($this->prereservation->enter_time) ? date('H:i', strtotime($this->prereservation->enter_time)) : null;
		$leave_time = !empty($this->prereservation->leave_time) ? date('H:i', strtotime($this->prereservation->leave_time)) : null;
		$venue_name = $this->venue->name_area . '・' . $this->venue->name_bldg . $this->venue->name_venue;
		$price_system = $this->prereservation->price_system === 2 ? '(音響HG)' : '';
		$smg_url = $this->venue->smg_url;
		$user_id = $this->prereservation->user_id;

		$subtitle = str_replace('${pre_reservation_id}', $pre_reservation_id, $subtitle);

		$send_html = str_replace('${company}', $company, $body);
		$send_html = str_replace('${login}', $login, $send_html);
		$send_html = str_replace('${pre_reservation_id}', $pre_reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $reserve_date, $send_html);
		$send_html = str_replace('${enter_time}', $enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $leave_time, $send_html);
		$send_html = str_replace('${venue_name}', $venue_name . $price_system, $send_html);
		$send_html = str_replace('${smg_url}', $smg_url, $send_html);
		$send_html = str_replace('${user_id}', $user_id, $send_html);

		return $this->view('maileclipse::templates.userFinPreRes')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
