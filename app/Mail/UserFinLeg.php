<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailTemplate;

class UserFinLeg extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @param string|int $template_id
	 * @param array $user
	 * @param array $data
	 * @return void
	 */
	public function __construct($template_id, $user, $data)
	{
		$this->template_id = $template_id;
		$this->user = $user;
		$this->data = $data;
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

		$company = $this->user['company'];
		$login = url('/user/login');
		$id = sprintf('%06d', $this->user['id']);
		$name = $this->user['first_name'] . $this->user['last_name'];
		$name_kana = $this->user['first_name_kana'] . $this->user['last_name_kana'];
		$post_code = $this->user['post_code'];
		$address = $this->user['address1'] . '　' . $this->user['address2'] . '　' . $this->user['address3'];
		$tel = $this->user['tel'];
		$mobile = $this->user['mobile'];
		$fax = $this->user['fax'];
		$email = $this->user['email'] ?? null;
		$research = $this->data['research'] ?? null;
		$where_from = $this->data['suggest_input'] ?? null . '　' . $this->data['oth_input'] ?? null;
		
		$send_html = str_replace('${company}', $company, $body);
		$send_html = str_replace('${login}', $login, $send_html);
		$send_html = str_replace('${id}', $id, $send_html);
		$send_html = str_replace('${name}', $name, $send_html);
		$send_html = str_replace('${name_kana}', $name_kana, $send_html);
		$send_html = str_replace('${post_code}', $post_code, $send_html);
		$send_html = str_replace('${address}', $address, $send_html);
		$send_html = str_replace('${tel}', $tel, $send_html);
		$send_html = str_replace('${mobile}', $mobile, $send_html);
		$send_html = str_replace('${fax}', $fax, $send_html);
		$send_html = str_replace('${email}', $email, $send_html);
		$send_html = str_replace('${research}', $research, $send_html);
		$send_html = str_replace('${where_from}', $where_from, $send_html);

		return $this->view('maileclipse::templates.userFinLeg')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
