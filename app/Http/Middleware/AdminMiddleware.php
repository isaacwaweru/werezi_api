<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if(auth()->check()) {
            if(auth()->user()->role == 'admin') {
                return $next($request);
            }

            if(auth()->user()->role == 'seller') {
                return redirect()->route('seller.dashboard');
            }

            Auth::logout();

            abort(403);
        }
        
        return redirect()->route('login');
    }
}
