<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Helpers\ReservationHelper;

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
    return $this->view('maileclipse::templates.payDayTwoDaysLeft')
      ->subject($this->subject)
      ->with([
        'company' => $this->data->company,
        'category' => $this->data->category,
        'reservation_id' => $this->data->reservation_id,
        'reserve_date' => $this->data->reserve_date,
        'user_id' => $this->data->user_id,
        'enter_time' => $this->data->enter_time,
        'leave_time' => $this->data->leave_time,
        'venue_name' => $this->data->venue_name,
        'smg_url' => $this->data->smg_url,
        'master_total' => $this->data->master_total,
        'invoice_number' => $this->data->invoice_number,
        'payment_limit' => ReservationHelper::formatDate($this->data->payment_limit),
      ]);
  }
}
