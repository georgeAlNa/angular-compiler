<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException as EloquentModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
    public function render($request, Throwable $e)
    {
        // Handle API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle API exceptions
     */
    protected function handleApiException(Request $request, Throwable $e): JsonResponse
    {
        // Custom exceptions
        if ($e instanceof ModelNotFoundException) {
            return $e->render();
        }

        if ($e instanceof ValidationException) {
            return $e->render();
        }

        if ($e instanceof UnauthorizedException) {
            return $e->render();
        }

        if ($e instanceof BusinessLogicException) {
            return $e->render();
        }

        // Laravel built-in exceptions
        if ($e instanceof LaravelValidationException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
                'code' => 'VALIDATION_ERROR'
            ], 422);
        }

        if ($e instanceof EloquentModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.record_not_found'),
                'code' => 'MODEL_NOT_FOUND'
            ], 404);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated'),
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthorized_access'),
                'code' => 'UNAUTHORIZED_ACCESS'
            ], 403);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.route_not_found'),
                'code' => 'ROUTE_NOT_FOUND'
            ], 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.method_not_allowed'),
                'code' => 'METHOD_NOT_ALLOWED'
            ], 405);
        }

        // Generic server error
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
        
        return response()->json([
            'success' => false,
            'message' => app()->environment('production') 
                ? __('messages.server_error') 
                : $e->getMessage(),
            'code' => 'SERVER_ERROR'
        ], $statusCode);
    }

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated'),
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}