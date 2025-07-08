<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingOnlyMiddleware
{
    /**
     * Handle an incoming request.
     */
   public function handle($request, Closure $next)
{
    if (auth()->user() && auth()->user()->role === 'marketing') {
        return $next($request);
    }

    abort(403, 'Unauthorized');
}
}
