<?php

namespace Teachat\Http\Middleware;

use Auth;
use Closure;

class RedirectIfParent
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
        //dd('P'.Auth::guard($guard)->user()->role_id);
        if (Auth::guard($guard)->user()->role_id != 3) {
            return abort(401);
        }

        return $next($request);
    }
}
