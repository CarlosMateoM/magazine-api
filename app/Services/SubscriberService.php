<?php

namespace App\Services;

use App\Models\NewsLetterSubscription;

class SubscriberService
{
    public function __construct()
    {

    }

    public function retrieveSubscriberInfByEmail(string $email)
    {
        return NewsLetterSubscription::where('email', $email)->firstOrFail();
    }
}
