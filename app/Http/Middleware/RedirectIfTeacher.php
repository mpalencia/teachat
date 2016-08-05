<?php

namespace Teachat\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //dd(Auth::guard($guard)->user()->role_id);))
        if (Auth::guard($guard)->user()->role_id != 2) {
            return abort(401);
        }

        return $next($request);
    }
}
