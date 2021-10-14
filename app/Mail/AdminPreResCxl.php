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
  public function __construct($user, $reservation, $venue)
  {
    $this->user = $user;
    $this->reservation = $reservation;
    $this->venue = $venue;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.adminPreResCxl')
      ->subject('管理者通知　SMGアクセア貸し会議室 仮押さえ キャンセル')
      ->with([
        'user' => $this->user,
        'reservation' => $this->reservation,
        'venue' => $this->venue,
      ]);
  }
}
