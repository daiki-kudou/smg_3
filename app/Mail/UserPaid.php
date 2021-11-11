<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPaid extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($reservation_data, $bill_data, $subject, $bill_or_add_bill)
  {
    $this->reservation_data = $reservation_data;
    $this->bill_data = $bill_data;
    $this->subject = $subject;
    $this->bill_or_add_bill = $bill_or_add_bill;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.userPaid')
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
        'invoice_number' => $this->bill_data->invoice_number,
        'master_total' => $this->bill_data->master_total,
        'payment_limit' => $this->bill_data->payment_limit,
        "bill_or_add_bill" => $this->bill_or_add_bill
      ]);
  }
}
