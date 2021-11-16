<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user, $url)
  {
    $this->user = $user;
    $this->url = $url;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.resetPasswordEmail')
      ->subject("パスワード変更のご確認（SMG貸し会議室）")
      ->with([
        'company' => $this->user->company,
        'url' => $this->url
      ]);
  }
}
