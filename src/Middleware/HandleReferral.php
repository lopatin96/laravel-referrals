<?php

namespace Atin\LaravelReferrals\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleReferral
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest() && $request->has('ref')) {
            cookie()->queue('referrer_id', $request->get('ref'), 43200); // 43200 minutes = 30 days
        }

        return $next($request);
    }
}