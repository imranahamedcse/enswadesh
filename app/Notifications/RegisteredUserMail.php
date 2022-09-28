<?php

namespace App\Notifications;

use App\Models\UserOtp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegisteredUserMail extends Notification
{
    use Queueable;

    public $userOtp;

    public function __construct(UserOtp $userOtp)
    {
        $this->userOtp = $userOtp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Thank you ' . $notifiable->name . ' notification.')
                    ->action('Notification Action', url('/login'))
                    ->line('Your OTP is '. $this->userOtp->otp )
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
