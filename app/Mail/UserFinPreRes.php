<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserFinPreRes extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user, $id, $date, $enter_time, $leave_time, $venue, $post_code, $address, $url)
  {
    $this->user = $user;
    $this->id = $id;
    $this->date = $date;
    $this->enter_time = $enter_time;
    $this->leave_time = $leave_time;
    $this->venue = $venue;
    $this->post_code = $post_code;
    $this->address = $address;
    $this->url = $url;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.userFinPreRes')
      ->subject('SMGアクセア貸し会議室 仮押えについて')
      ->with([
        'user' => $this->user,
        'id' => $this->id,
        'date' => $this->date,
        'enter_time' => $this->enter_time,
        'leave_time' => $this->leave_time,
        'venue' => $this->venue,
        'post_code' => $this->post_code,
        'address' => $this->address,
        'url' => $this->url,
      ]);
  }
}
