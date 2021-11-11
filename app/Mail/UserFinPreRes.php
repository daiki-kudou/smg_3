<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserFinPreRes extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data, $subject)
  {
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
    return $this->view('maileclipse::templates.userFinPreRes')
      ->subject($this->subject)
      ->with([
        'company' => $this->data->company,
        'pre_reservation_id' => $this->data->pre_reservation_id,
        'reserve_date' => $this->data->reserve_date,
        'enter_time' => $this->data->enter_time,
        'leave_time' => $this->data->leave_time,
        'venue_name' => $this->data->venue_name,
        'smg_url' => $this->data->smg_url
      ]);
  }
}
