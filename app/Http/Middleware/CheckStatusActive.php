<?php

namespace App\Http\Middleware;

use Closure;
use Alert;

class CheckStatusActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->status != 0) {
            return response()->view('guest.notpermission', [], 404);
        }
        return $next($request);
    }
}
