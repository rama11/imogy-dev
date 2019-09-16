<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ProjectRole
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
        if(Auth::user()->jabatan == 1 || Auth::user()->jabatan == 4 || Auth::user()->jabatan == 5){
            return $next($request);
        }
            return abort(404);
    }
}
