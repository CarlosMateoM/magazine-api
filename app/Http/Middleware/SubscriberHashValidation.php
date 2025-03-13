<?php

namespace App\Http\Middleware;

use App\Models\NewsLetterSubscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriberHashValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subscriberId = $request->route('id');
        $incomingSignature = $request->route('signature');
        $subscriber = NewsLetterSubscription::find($subscriberId);

        if($subscriber == null){
            return response()->json(
                [
                    'error' => 'Resource not found. The requesting user does not exist',
                ]
                , 403);
        }

        $expectedSignature = hash_hmac('SHA256', $subscriber->email, config('app.key'));

        if (!hash_equals($expectedSignature, $incomingSignature)) {
            return response()->json(
                [
                    'error' => 'Invalid email. this user cannot perform this operation.',
                ]
            , 403);
        }

        return $next($request);
    }
}
