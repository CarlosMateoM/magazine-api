<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindSubscriberByEmailRequest;
use App\Http\Requests\StoreNewsLetterSubscriptionRequest;
use App\Http\Requests\UpdateNewsLetterSubscriptionRequest;
use App\Http\Resources\RetrieveSubscriberResource;
use App\Models\NewsLetterSubscription;
use App\Services\NewsLetterSubscriptionService;


class SubscriberController extends Controller
{

    public function __construct(
        private NewsLetterSubscriptionService $newsLetterSubscriptionService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsLetterSubscriptionRequest $request)
    {
        return $this->newsLetterSubscriptionService->createNewsLetterSubscription($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsLetterSubscription $newsLetterSubscription, $signature, $expires): NewsLetterSubscription
    {
        return $this->newsLetterSubscriptionService->getNewsLetterSubscription($newsLetterSubscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsLetterSubscriptionRequest $request, NewsLetterSubscription $newsLetterSubscription, $signature, $expires): NewsLetterSubscription
    {
        return $this->newsLetterSubscriptionService->updateNewsLetterSubscription($request->validated(), $newsLetterSubscription);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsLetterSubscription $newsLetterSubscription, $signature, $expires): ?bool
    {
        return $this->newsLetterSubscriptionService->deleteNewsLetterSubscription($newsLetterSubscription);
    }

    public function retrieveSubscriberInf(FindSubscriberByEmailRequest $request): RetrieveSubscriberResource
    {
        $subscriber = $this->newsLetterSubscriptionService->retrieveSubscriberInfByEmail($request->validated()['email']);
        return new RetrieveSubscriberResource($subscriber);
    }

    public function notificationServiceToogle (NewsLetterSubscription $newsLetterSubscription, $signature, $expires): NewsLetterSubscription
    {
        return $this->newsLetterSubscriptionService->toggleNotificationService($newsLetterSubscription);
    }
}
