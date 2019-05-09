<?php

namespace App\Http\Middleware;

use Closure;
use Alert;
use Illuminate\Support\Facades\Auth;

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
            Auth::logout();
            return response()->view('guest.404', [], 404);
        }
        return $next($request);
    }
}
