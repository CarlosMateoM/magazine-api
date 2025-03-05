<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerifiedApi
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() instanceOf MustVerifyEmail && !$request->user()->hasVerifiedEmail()) {
            return response()->json(
                [
                    'error' => 'email not verified'
                ],
                403
            );
        }
        return $next($request);
    }
}
