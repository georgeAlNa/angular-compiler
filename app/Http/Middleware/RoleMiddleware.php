<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Authentication is already handled by auth:sanctum middleware
        // This middleware only handles role authorization
        $userRole = $request->user()->role;
        $allowedRoles = array_map(fn($role) => Role::from($role), $roles);

        if (!in_array($userRole, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthorized_access'),
                'code' => 'UNAUTHORIZED_ACCESS'
            ], 403);
        }

        return $next($request);
    }
}
