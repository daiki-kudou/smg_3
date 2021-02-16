<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmReservationByUser extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($reservation_id)
  {
    $this->reservation_id = $reservation_id;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('user.mails.confirm_reservation')
      ->subject('予約が完了しました')
      ->with(['reservation_id' => $this->reservation_id]);
  }
}
