<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Preuser;


class SendPreuser extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($id, $token, $email, $link)
  {
    $this->id = $id;
    $this->token = $token;
    $this->email = $email;
    $this->link = $link;
  }
  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('user.preusers.create')
      ->subject('メール認証をお願いします')
      ->with([
        'id' => $this->id,
        'token' => $this->token,
        'email' => $this->email,
        'link' => $this->email,
      ]);
  }
}
