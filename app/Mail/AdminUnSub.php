<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminUnSub extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user_company)
  {
    $this->user_company = $user_company;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.admiUnSub')
      ->subject('【管理者通知】SMGアクセア貸し会議室　退会完了について')->with(['user_company' => $this->user_company]);
  }
}
