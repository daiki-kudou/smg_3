<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserFinDblChk extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data, $subject, $master_total)
  {
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
    return $this->view('maileclipse::templates.userFinDblChk')
      ->subject($this->subject)
      ->with([
        'company' => $this->data->company,
        'reservation_id' => $this->data->reservation_id,
        'reserve_date' => $this->data->reserve_date,
        'user_id' => $this->data->user_id,
        'enter_time' => $this->data->enter_time,
        'leave_time' => $this->data->leave_time,
        'venue_name' => $this->data->venue_name,
        'smg_url' => $this->data->smg_url,
        'master_total' => $this->master_total,
      ]);
  }
}
