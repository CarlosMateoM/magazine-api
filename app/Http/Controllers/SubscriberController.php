<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindSubscriberByEmailRequest;
use App\Http\Resources\RetrieveSubscriberResource;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    public function __construct(
        private SubscriberService $subscriberService)
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FindSubscriberByEmailRequest $request)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function retrieveSubscriberInf(FindSubscriberByEmailRequest $request): RetrieveSubscriberResource
    {
        $subscriber = $this->subscriberService->retrieveSubscriberInfByEmail($request->validated()['email']);
        return new RetrieveSubscriberResource($subscriber);
    }
}
