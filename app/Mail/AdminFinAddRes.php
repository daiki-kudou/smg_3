<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminFinAddRes extends Mailable
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
    return $this->view('maileclipse::templates.adminFinAddRes')
      ->subject('管理者通知　〇△×貸し会議室追加予約受付完了')
      ->with([
        // 'id' => $this->id,
        // 'token' => $this->token,
        // 'email' => $this->email,
        // 'link' => $this->link,
      ]);
  }
}
