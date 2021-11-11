<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDelRes extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($reservation_data, $subject, $bill_data, $equipment_data, $service_data, $layout_data)
  {
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
    return $this->view('maileclipse::templates.userDelRes')
      ->subject($this->subject)
      ->with([
        'company' => $this->reservation_data->company,
        'user_id' => $this->reservation_data->user_id,
        'reservation_id' => $this->reservation_data->reservation_id,
        'reserve_date' => $this->reservation_data->reserve_date,
        'enter_time' => $this->reservation_data->enter_time,
        'leave_time' => $this->reservation_data->leave_time,
        'venue_name' => $this->reservation_data->venue_name,
        'smg_url' => $this->reservation_data->smg_url,
        'in_charge' => $this->reservation_data->in_charge,
        'tel' => $this->reservation_data->tel,
        'price_system' => $this->reservation_data->price_system,
        'board_flag' => $this->reservation_data->board_flag,
        'event_name1' => $this->reservation_data->event_name1,
        'event_name2' => $this->reservation_data->event_name2,
        'event_owner' => $this->reservation_data->event_owner,
        'event_start' => $this->reservation_data->event_start,
        'event_finish' => $this->reservation_data->event_finish,
        'eat_in' => $this->reservation_data->eat_in,
        'eat_in_prepare' => $this->reservation_data->eat_in_prepare,
        'luggage_flag' => $this->reservation_data->luggage_flag,
        'luggage_count' => $this->reservation_data->luggage_count,
        'luggage_arrive' => $this->reservation_data->luggage_arrive,
        'luggage_return' => $this->reservation_data->luggage_return,
        'admin_details' => $this->reservation_data->admin_details,
        'bill_data' => $this->bill_data,
        'equipment_data' => $this->equipment_data,
        'service_data' => $this->service_data,
        'layout_data' => $this->layout_data,
      ]);
  }
}
