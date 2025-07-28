<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     * This middleware intercepts authentication responses and formats them consistently.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if this is an unauthenticated JSON response from Sanctum
        if ($response instanceof JsonResponse &&
            $response->getStatusCode() === 401 &&
            ($request->expectsJson() || $request->is('api/*'))) {

            $data = $response->getData(true);

            // If it's the default Laravel unauthenticated response, replace it
            if (isset($data['message']) && $data['message'] === 'Unauthenticated.') {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                    'code' => 'UNAUTHENTICATED'
                ], 401);
            }
        }

        return $response;
    }
}