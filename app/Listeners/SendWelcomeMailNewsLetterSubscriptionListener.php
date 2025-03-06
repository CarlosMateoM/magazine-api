<?php

namespace App\Listeners;

use App\Events\WelcomeMailNewsLetterSubscriptionEvent;
use App\Mail\WelcomeNewsLetterSubscriptionMailable;
use App\Models\NewsLetterSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendWelcomeMailNewsLetterSubscriptionListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */

    public $tries = 3;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WelcomeMailNewsLetterSubscriptionEvent $event): void
    {
        $subscriber = NewsLetterSubscription::findOrFail($event->idSubscriber);
        Mail::to($subscriber->email)->send(new WelcomeNewsLetterSubscriptionMailable($subscriber));
    }

    public function failed(WelcomeMailNewsLetterSubscriptionEvent $event, Exception $exception): void
    {
        Throw new Exception($exception->getMessage());
    }
}
