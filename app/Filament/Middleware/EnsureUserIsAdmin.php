<?php

namespace App\Filament\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'You do not have access to the admin panel.');
        }

        return $next($request);
    }
}
