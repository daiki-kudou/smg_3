<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Consts\MailTemplateConst;
use App\Models\MailTemplate;

class UserCxlChck extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($cxl_data, $subject)
	{
		$this->template_id = MailTemplateConst::CXL_APPROVE;

		$this->cxl_data = $cxl_data;
		$this->subject = $subject;
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.userCxlChck')
		//   ->subject($this->subject)
		//   ->with([
		//     'company' => $this->cxl_data->company,
		//     'user_id' => $this->cxl_data->user_id,
		//     'reservation_id' => $this->cxl_data->reservation_id,
		//     'reserve_date' => $this->cxl_data->reserve_date,
		//     'enter_time' => $this->cxl_data->enter_time,
		//     'leave_time' => $this->cxl_data->leave_time,
		//     'venue_name' => $this->cxl_data->venue_name,
		//     'smg_url' => $this->cxl_data->smg_url,
		//     'invoice_number' => $this->cxl_data->invoice_number,
		//     'master_total' => $this->cxl_data->master_total,
		//   ]);

		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$category = 'キャンセル';
		$body = $template->body;

		$subtitle = str_replace('${reservation_id}', $this->cxl_data->reservation_id, $subtitle);

		$send_html = str_replace('${company}', $this->cxl_data->company, $body);
		$send_html = str_replace('${reservation_id}', $this->cxl_data->reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $this->cxl_data->reserve_date, $send_html);
		$send_html = str_replace('${user_id}', $this->cxl_data->user_id, $send_html);
		$send_html = str_replace('${category}', $category, $send_html);
		$send_html = str_replace('${invoice_number}', $this->cxl_data->invoice_number, $send_html);
		$send_html = str_replace('${enter_time}', $this->cxl_data->enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $this->cxl_data->leave_time, $send_html);
		$send_html = str_replace('${venue_name}', $this->cxl_data->venue_name, $send_html);
		$send_html = str_replace('${smg_url}', $this->cxl_data->smg_url, $send_html);
		$send_html = str_replace('${master_total}', $this->cxl_data->master_total, $send_html);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.userCxlChck')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
