<?php

namespace App\Mail;

use App\Models\User;
use http\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetPasswordMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;
    private $url;
    /**
     * Create a new message instance.
     */
    public function __construct(
        private User $user,
        private $token,
    )
    {
        $this->url = config('app.frontend_url').'/reset-password?' . http_build_query([
                'token' => $this->token,
                'email' => $this->user['email']
            ]);

        Log::info('URL en el mailable:', ['url' => $this->url]);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('adactsup@gmail.com', 'La region'),
            subject: 'Restablecer contraseña'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'AuthenticationViews.reset-password-view',
            with: [
                'username' => $this->user->name,
                'url' => $this->url
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
