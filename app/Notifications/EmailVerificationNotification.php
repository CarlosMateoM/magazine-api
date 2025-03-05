<?php

namespace App\Notifications;

use App\Mail\EmailVerificationMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public int $tries = 3;

    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): Mailable
    {
        Log::info("notificacion de emial",["user" => $notifiable]);
        return (new EmailVerificationMailable($notifiable, $this->getEmailVerificationURL($notifiable)))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function getEmailVerificationURL($notifiable)
    {

        // especifico los query params para la url
        $params = [
            "expires" => now()->addMinutes(60)->getTimestamp(),
            "id" => $notifiable->getKey(),
            "hash" => sha1($notifiable->getEmailForVerification()),
        ];

        // genero la firma para la URL
        $signature = hash_hmac("sha256", http_build_query($params), config('app.key'));

        // se contruye y se retorna la URL
        return config('app.frontend_url') . '/verify-email?' . http_build_query($params + ["signature" => $signature]);

    }

}
