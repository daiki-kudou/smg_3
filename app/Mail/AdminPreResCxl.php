<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminPreResCxl extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($pre_reservation, $user)
  {
    $this->pre_reservation = $pre_reservation;
    $this->user = $user;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.adminPreResCxl')
      ->subject('管理者通知　〇△×貸し会議室 仮押さえ キャンセル')
      ->with([
        'pre_reservation' => $this->pre_reservation,
        'user' => $this->user,
      ]);
  }
}
