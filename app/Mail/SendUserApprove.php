<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserApprove extends Mailable
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
    return $this->view('user.mails.send_email_approve')
      ->subject('会場予約の承認をお願い申し上げます')->with(['reservation_id' => $this->reservation_id]);
  }
}
