<?php

namespace App\Http\Middleware;

use Closure;
use Alert;

class CheckAdminRole
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
        if ($request->user()->role != 1) {
            return response()->view('guest.404', [], 404);
        }
        return $next($request);
    }
}
