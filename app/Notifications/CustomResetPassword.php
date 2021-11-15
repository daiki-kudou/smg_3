<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use App\Service\SendSMGEmail;




class CustomResetPassword extends ResetPassword
{

  public function toMail($user)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    }
    $url = url(route('user.password.reset', ['token' => $this->token, 'email' => $user->email], false));

    // $SendSMGEmail = new SendSMGEmail();
    // return $SendSMGEmail->AuthSend("リセットパスワード", ['user' => $user, 'url' => $url]);

    $mail = new ResetPasswordEmail($user, $url);
    return $mail->to($user->email);
  }
}
