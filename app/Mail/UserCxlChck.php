<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCxlChck extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($company, $date, $enter_time, $leave_time, $venue, $cxl_price)
  {
    $this->company = $company;
    $this->date = $date;
    $this->enter_time = $enter_time;
    $this->leave_time = $leave_time;
    $this->venue = $venue;
    $this->cxl_price = $cxl_price;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('maileclipse::templates.userCxlChck')
      ->subject('〇△×貸し会議室　キャンセル承認のお願い')
      ->with([
        'company' => $this->company,
        'date' => $this->date,
        'enter_time' => $this->enter_time,
        'leave_time' => $this->leave_time,
        'venue' => $this->venue,
        'cxl_price' => $this->cxl_price,
      ]);
  }
}
