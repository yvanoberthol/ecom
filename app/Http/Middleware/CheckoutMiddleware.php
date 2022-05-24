<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class CheckoutMiddleware
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
        if ((int)BusinessSetting::where('type', 'guest_checkout_active')->first()->value !== 1) {
            if(Auth::check()){
                return $next($request);
            }

            session(['link' => url()->current()]);
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}
