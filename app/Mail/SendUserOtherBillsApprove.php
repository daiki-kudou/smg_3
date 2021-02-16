<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserOtherBillsApprove extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($bill)
  {
    $this->bill = $bill;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('user.mails.other_send_approve')
      ->subject('追加予約の承認をお願い申し上げます')->with(['bill' => $this->bill]);
  }
}
