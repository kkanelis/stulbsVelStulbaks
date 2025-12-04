<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilamentAdminOnly
{
    /**
     * Handle an incoming request.
     * Allow only users with role == 'admin' to access Filament panel.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (! $user || ($user->role ?? null) !== 'admin') {
            // If JSON requested, return 403 JSON, otherwise abort with 403 page.
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Admins only.'], 403);
            }

            abort(403, 'Forbidden. Admins only.');
        }

        return $next($request);
    }
}
