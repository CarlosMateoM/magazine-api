<?php

namespace App\Listeners;

use App\Events\SuccessfulPasswordResetEvent;
use App\Mail\SuccessfullPasswordResetMailable;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PasswordResetConfirmationEmailSentListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SuccessfulPasswordResetEvent $event): void
    {
        $user = User::findOrFail($event->userId);
        Mail::to($user['email'])->send(new SuccessfullPasswordResetMailable($user));
    }

    public function failed(SuccessfulPasswordResetEvent $event, Throwable $exception): void
    {
        Log::error('Error en ejecucion del listener: PasswordResetConfirmationEmailSentListener ',
        [
            'event' => get_class($event),
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
