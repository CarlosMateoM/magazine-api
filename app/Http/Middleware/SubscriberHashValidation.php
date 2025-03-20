<?php

namespace App\Http\Middleware;

use App\Models\NewsLetterSubscription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $subscriber = $request->route('newsLetterSubscription');
        Log::error("acceso a emial", ["sub" => $subscriber]);
        $incomingSignature = $request->route('signature');
        $expiresRequest = $request->route('expires');

        if(now()->getTimestamp() > $expiresRequest) {
            return response()->json(
                [
                    "error" => "expired url",
                ]
            , 410);
        }

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
