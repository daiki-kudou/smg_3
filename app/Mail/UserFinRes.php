<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Consts\MailTemplateConst;
use App\Models\MailTemplate;

class UserFinRes extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($reservation_data, $subject, $bill_data, $equipment_data, $service_data, $layout_data)
	{
		$this->template_id = MailTemplateConst::RESERVATION_DONE;

		$this->reservation_data = $reservation_data;
		$this->subject = $subject;
		$this->bill_data = $bill_data;
		$this->equipment_data = $equipment_data;
		$this->service_data = $service_data;
		$this->layout_data = $layout_data;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// return $this->view('maileclipse::templates.userFinRes')
		// 	->subject($this->subject)
		// 	->with([
		// 		'company' => $this->reservation_data->company,
		// 		'user_id' => $this->reservation_data->user_id,
		// 		'reservation_id' => $this->reservation_data->reservation_id,
		// 		'reserve_date' => $this->reservation_data->reserve_date,
		// 		'enter_time' => $this->reservation_data->enter_time,
		// 		'leave_time' => $this->reservation_data->leave_time,
		// 		'venue_name' => $this->reservation_data->venue_name,
		// 		'smg_url' => $this->reservation_data->smg_url,
		// 		'in_charge' => $this->reservation_data->in_charge,
		// 		'tel' => $this->reservation_data->tel,
		// 		'price_system' => $this->reservation_data->price_system,
		// 		'board_flag' => $this->reservation_data->board_flag,
		// 		'event_name1' => $this->reservation_data->event_name1,
		// 		'event_name2' => $this->reservation_data->event_name2,
		// 		'event_owner' => $this->reservation_data->event_owner,
		// 		'event_start' => $this->reservation_data->event_start,
		// 		'event_finish' => $this->reservation_data->event_finish,
		// 		'eat_in' => $this->reservation_data->eat_in,
		// 		'eat_in_prepare' => $this->reservation_data->eat_in_prepare,
		// 		'luggage_flag' => $this->reservation_data->luggage_flag,
		// 		'luggage_count' => $this->reservation_data->luggage_count,
		// 		'luggage_arrive' => $this->reservation_data->luggage_arrive,
		// 		'luggage_return' => $this->reservation_data->luggage_return,
		// 		'admin_details' => $this->reservation_data->admin_details,
		// 		'bill_data' => $this->bill_data,
		// 		'equipment_data' => $this->equipment_data,
		// 		'service_data' => $this->service_data,
		// 		'layout_data' => $this->layout_data,
		// 	]);

		$company = $this->reservation_data->company;
		$user_id = $this->reservation_data->user_id;
		$reservation_id = $this->reservation_data->reservation_id;
		$reserve_date = $this->reservation_data->reserve_date;
		$enter_time = $this->reservation_data->enter_time;
		$leave_time = $this->reservation_data->leave_time;
		$venue_name = $this->reservation_data->venue_name;
		$smg_url = $this->reservation_data->smg_url;
		$in_charge = $this->reservation_data->in_charge;
		$tel = $this->reservation_data->tel;
		$price_system = $this->reservation_data->price_system;
		$board_flag = $this->reservation_data->board_flag;
		$event_name1 = $this->reservation_data->event_name1;
		$event_name2 = $this->reservation_data->event_name2;
		$event_owner = $this->reservation_data->event_owner;
		$event_start = $this->reservation_data->event_start;
		$event_finish = $this->reservation_data->event_finish;
		$eat_in = $this->reservation_data->eat_in;
		$eat_in_prepare = $this->reservation_data->eat_in_prepare;
		$luggage_flag = $this->reservation_data->luggage_flag;
		$luggage_count = $this->reservation_data->luggage_count;
		$luggage_arrive = $this->reservation_data->luggage_arrive;
		$luggage_return = $this->reservation_data->luggage_return;
		$admin_details = $this->reservation_data->admin_details;
		$bill_data = $this->bill_data;
		$equipment_data = $this->equipment_data;
		$service_data = $this->service_data;
		$layout_data = $this->layout_data;

		// 音響ハイグレード
		if ($price_system == 2) {
			$price_system = '・音響ハイグレード:する<br>';
			$price_system .= '<br>';
		} else {
			$price_system = '';
		}
		// 案内板
		if ($board_flag == 1) {
			$board_flag = '';
			$board_flag .= '・案内板の作成：';
			$board_flag .= '<br>案内板の作成 : する';
			$board_flag .= '<br>イベント名称1行目 : ' . $event_name1;
			if (!empty($event_name2)) {
				$board_flag .= '<br>イベント名称2行目 : ' . $event_name2;
			}
			if (!empty($event_owner)) {
				$board_flag .= '<br>主催者名 : ' . $event_owner;
			}
			if (!empty($event_start) && !empty($event_finish)) {
				$board_flag .= '<br>イベント時間 : ' . $event_start . '~' . $event_finish . '<br>';
			}
			$board_flag .= '<br>';
		} else {
			$board_flag = '';
		}
		// 室内飲食
		if ($eat_in == 1) {
			$eat_in = '・室内飲食 : あり';
			if ($eat_in_prepare == 1) {
				$eat_in .= '<br>手配済み<br>';
			} elseif ($eat_in_prepare == 2) {
				$eat_in .= '<br>検討中<br>';
			}
			$eat_in .= '<br>';
		} else {
			$eat_in = '';
		}
		// 有料備品
		if (count($equipment_data) > 0) {
			$equipment_html = '・有料備品 :<br>';
			foreach ($equipment_data as $key => $e) {
				$equipment_html .= ($e['unit_item'] . ' ' . number_format($e['unit_cost']) . '円 ' . $e['unit_count'] . '個<br>');
			}
			$equipment_html .= '<br>';
		} else {
			$equipment_html = '';
		}
		// 有料サービス
		if (count($service_data) > 0) {
			$service_html = '・有料サービス :<br>';
			foreach ($service_data as $key => $s) {
				$service_html .= ($s['unit_item'] . ' ' . number_format($s['unit_cost']) . '円 ' . '<br>');
			}
			$service_html .= '<br>';
		} else {
			$service_html = '';
		}
		// レイアウト変更
		if (count($layout_data) > 0) {
			$layout_html = 'レイアウト変更 :<br>';
			foreach ($layout_data as $key => $l) {
				$layout_html .= ($l . '<br>');
			}
			$layout_html .= '<br>';
		} else {
			$layout_html = '';
		}
		// 荷物預かり
		if ($luggage_flag == 1) {
			$luggage_flag = '・荷物預かり : あり<br>';
			$luggage_flag .= '事前に預かる荷物（目安）：' . $luggage_count . ' 個<br>';
			$luggage_flag .= '事前荷物の到着日（午前指定） : ' . $luggage_arrive . '<br>';
			$luggage_flag .= '事後返送する荷物 : ' . $luggage_return . ' 個<br>';
			$luggage_flag .= '<br>';
		} else {
			$luggage_flag = '';
		}
		// 管理者備考
		if (!empty($admin_details)) {
			$admin_details = '・備考：<br>';
			$admin_details .= '<br>';
		} else {
			$admin_details = '';
		}

		$template = MailTemplate::find($this->template_id);
		$subtitle = $template->subtitle;
		$body = $template->body;

		$subtitle = str_replace('${category}', '会場予約', $subtitle);
		$subtitle = str_replace('${reservation_id}', $reservation_id, $subtitle);

		$send_html = str_replace('${company}', $company, $body);
		$send_html = str_replace('${user_id}', $user_id, $send_html);
		$send_html = str_replace('${category}', '会場予約', $send_html);
		$send_html = str_replace('${reservation_id}', $reservation_id, $send_html);
		$send_html = str_replace('${reserve_date}', $reserve_date, $send_html);
		$send_html = str_replace('${enter_time}', $enter_time, $send_html);
		$send_html = str_replace('${leave_time}', $enter_time, $send_html);
		$send_html = str_replace('${venue_name}', $venue_name, $send_html);
		$send_html = str_replace('${in_charge}', $in_charge, $send_html);
		$send_html = str_replace('${tel}', $tel, $send_html);
		$send_html = str_replace('${price_system}', $price_system, $send_html);
		$send_html = str_replace('${board_flag}', $board_flag, $send_html);
		$send_html = str_replace('${eat_in}', $eat_in, $send_html);
		$send_html = str_replace('${equipment_html}', $equipment_html, $send_html);
		$send_html = str_replace('${service_html}', $service_html, $send_html);
		$send_html = str_replace('${layout_html}', $layout_html, $send_html);
		$send_html = str_replace('${luggage_flag}', $luggage_flag, $send_html);
		$send_html = str_replace('${admin_details}', $admin_details, $send_html);
		$send_html = str_replace('${master_total}', $bill_data->master_total, $send_html);
		$send_html = str_replace('${payment_limit}', $bill_data->payment_limit, $send_html);
		$send_html = str_replace('${smg_url}', $smg_url, $send_html);
		$send_html = str_replace('${invoice_number}', $bill_data->invoice_number, $send_html);
		$send_html = str_replace('${login}', url('/user/login'), $send_html);

		return $this->view('maileclipse::templates.userFinRes')
			->subject($subtitle)
			->with([
				'send_html' => $send_html,
			]);
	}
}
