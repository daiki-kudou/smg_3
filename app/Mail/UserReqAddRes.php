<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserReqAddRes extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(
    // $id, $token, $email, $link
  )
  {
    // $this->id = $id;
    // $this->token = $token;
    // $this->email = $email;
    // $this->link = $link;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.userReqAddRes')
      ->subject('追加の備品・サービス（その他）を受け付けました	')
      ->with([
        // 'id' => $this->id,
        // 'token' => $this->token,
        // 'email' => $this->email,
        // 'link' => $this->link,
      ]);
  }
}
