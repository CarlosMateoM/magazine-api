<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsLetterSubscriptionRequest;
use App\Http\Requests\UpdateNewsLetterSubscriptionRequest;
use App\Http\Requests\UpdateStatusIsNotificationEnableRequest;
use App\Http\Resources\NewsLetterSubscriptionResource;
use App\Models\NewsLetterSubscription;
use App\Services\NewsLetterSubscriptionService;
use Illuminate\Http\Request;

class NewsLetterSubscriptionController extends Controller
{

    public function __construct(
        private NewsLetterSubscriptionService $newsLetterSubscriptionService
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->newsLetterSubscriptionService->getNewsLetterSubscriptions($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsLetterSubscriptionRequest $request)
    {
        return new NewsLetterSubscriptionResource($this->newsLetterSubscriptionService->createNewsLetterSubscription($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsLetterSubscription $newsLetterSubscription)
    {
        return $this->newsLetterSubscriptionService->getNewsLetterSubscription($newsLetterSubscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsLetterSubscriptionRequest $request, NewsLetterSubscription $newsLetterSubscription)
    {
        $this->newsLetterSubscriptionService->updateNewsLetterSubscription($request->validated(), $newsLetterSubscription);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsLetterSubscription $newsLetterSubscription): ?bool
    {
        return $this->newsLetterSubscriptionService->deleteNewsLetterSubscription($newsLetterSubscription);
    }

    public function updateStatusIsNotificationEnabled(NewsLetterSubscription $newsLetterSubscription): NewsLetterSubscription
    {
        return $this->newsLetterSubscriptionService->toggleNotificationService($newsLetterSubscription);
    }
}
