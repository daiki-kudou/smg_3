<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Auth\Notifications\ResetPassword;


class CustomResetPassword extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    }

    return (new MailMessage)
      ->subject(Lang::get('Reset Password Notification'))
      ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
      // 以下修正　url(route('password.reset　から　url(route('user.password.resetへ
      ->action(Lang::get('Reset Password'), url(route('user.password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
      ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
      ->line(Lang::get('If you did not request a password reset, no further action is required.'));
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
