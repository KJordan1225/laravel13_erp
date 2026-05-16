<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'You must be logged in.');
        }

        if (!$user->hasRole($role)) {
            abort(403, 'You do not have the required role.');
        }

        return $next($request);
    }
}