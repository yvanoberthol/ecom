<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && isCustomer() && !Auth::user()->banned) {
            return $next($request);
        }

        session(['link' => url()->current()]);
        return redirect()->route('user.login');
    }
}
