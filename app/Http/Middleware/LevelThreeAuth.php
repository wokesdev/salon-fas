<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelThreeAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role->level == 3) {
                return $next($request);
            }

            else {
                abort(403);
            }
        }

        else {
            return redirect('login')->with('status', 'Silakan login terlebih dahulu.');
        }
    }
}
