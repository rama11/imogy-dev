<<<<<<< HEAD
<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class TisygyRole
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
        if(Auth::user()->jabatan == 2 || Auth::user()->jabatan == 4 || Auth::user()->jabatan == 5){
            return $next($request);
        }
            return abort(404);
    }
}
=======
<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
class TisygyRole
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
        if(Auth::user()->jabatan == 2 || Auth::user()->jabatan == 4 || Auth::user()->jabatan == 5){
            return $next($request);
        }
            return abort(404);
    }
}
>>>>>>> 3e17c99e9af56c1738f5649055aacfffd23d3841
