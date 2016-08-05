<?php

namespace Teachat\Http\Middleware;

use Auth;
use Closure;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //dd('A'.Auth::guard($guard)->user()->role_id);
        if (Auth::guard($guard)->user()->role_id != 1) {
            return abort(401);
        }

        return $next($request);
    }
}
