<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is coming from a Flutter application
        if ($request->header('User-Agent') === 'Flutter') {
            // If the user is not authenticated or not an admin, abort with a 403 Forbidden response
        if (!Auth::check() || !Auth::user() || !Auth::user()->is_admin) {
            abort(403);
        }
        }

        return $next($request);
    }
}
