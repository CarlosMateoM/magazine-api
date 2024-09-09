<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json(['message' => 'Resource not found.'], 404);
        }

        if($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json(['message' => 'The given data was invalid.', 'errors' => $exception->errors()], 422);
        }

        if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json(['message' => 'Method not allowed.'], 405);
        }

        if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        return parent::render($request, $exception);
    }
}
