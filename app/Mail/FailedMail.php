<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailedMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($exception, $class_name, $time)
  {
    $this->exception = $exception;
    $this->class_name = $class_name;
    $this->time = $time;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.failedMail')
      ->subject('【管理者通知：メール送信失敗】')->with(
        [
          'exception' => $this->exception,
          'class_name' => $this->class_name,
          'time' => $this->user_email,
        ]
      );
  }
}
