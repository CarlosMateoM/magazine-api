<?php

namespace App\Services;

use App\Events\WelcomeMailNewsLetterSubscriptionEvent;
use App\Http\Requests\StoreNewsLetterSubscriptionRequest;
use App\Http\Requests\UpdateNewsLetterSubscriptionRequest;
use App\Models\NewsLetterSubscription;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;


class NewsLetterSubscriptionService
{

    public function getNewsLetterSubscriptions(Request $request)
    {
        return QueryBuilder::for(NewsLetterSubscription::class)
            ->allowedFilters(['name', 'email'])
            ->paginate($request->input('per_page', config('constants.default_per_page')))->appends($request->query());
    }

    public function getNewsLetterSubscription(NewsLetterSubscription $newsLetterSubscription)
    {
        return $newsLetterSubscription;
    }

    public function createNewsLetterSubscription(Array $data){
        return DB::transaction(function () use ($data) {
            $newSubscriber = NewsLetterSubscription::create($data);
            WelcomeMailNewsLetterSubscriptionEvent::dispatch($newSubscriber->id);
            return $newSubscriber;
        });
    }

    public function updateNewsLetterSubscription(Array $data, NewsLetterSubscription $newsLetterSubscription)
    {
        $newsLetterSubscription->update($data);
        return $newsLetterSubscription;
    }

    public function deleteNewsLetterSubscription(NewsLetterSubscription $newsLetterSubscription)
    {
        return $newsLetterSubscription->delete();
    }

    public function updateIsNotificationEnabled(Array $data ,NewsLetterSubscription $newsLetterSubscription): NewsLetterSubscription
    {
        $newsLetterSubscription->update($data);
        return $newsLetterSubscription;
    }

    public function retrieveSubscriberInfByEmail(string $email)
    {
        return NewsLetterSubscription::where('email', $email)->firstOrFail();
    }

    public function toggleNotificationService (NewsLetterSubscription $subscriber){
        $subscriber->isNotificationEnabled = !$subscriber->isNotificationEnabled;
        $subscriber->save();
        return $subscriber;
    }


}
