<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
    return $this->view('maileclipse::templates.userCxlChck')
      ->subject($this->subject)
      ->with([
        'company' => $this->cxl_data->company,
        'user_id' => $this->cxl_data->user_id,
        'reservation_id' => $this->cxl_data->reservation_id,
        'reserve_date' => $this->cxl_data->reserve_date,
        'enter_time' => $this->cxl_data->enter_time,
        'leave_time' => $this->cxl_data->leave_time,
        'venue_name' => $this->cxl_data->venue_name,
        'smg_url' => $this->cxl_data->smg_url,
        'invoice_number' => $this->cxl_data->invoice_number,
        'master_total' => $this->cxl_data->master_total,
      ]);
  }
}
