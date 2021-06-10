<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPreResToRes extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($pre_reservation)
  {
    $this->pre_reservation = $pre_reservation;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.userPreResToRes')
      ->subject('【〇△×貸し会議室】　予約申込受付のお知らせ')->with(['pre_reservation' => $this->pre_reservation]);
  }
}
