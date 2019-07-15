<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class Debugging
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

		if(Auth::user()->jabatan == "5" || Auth::user()->jabatan == "4"){
			
			if($request->path() == "getDashboard"){
				$request->client = "KMDG";
				return $next($request);
			} else if ($request->path() == "getClientList") {
				$request->client = "KMDG";
				return $next($request);
			} else if ($request->path() == "getPerformance") {
				$request->client = "KMDG";
				return $next($request);
			} else if ($request->path() == "getPerformance2") {
				$request->client = "KMDG";
				return $next($request);
			}

			else{
				return $next($request);
			} 

		} else {
			return $next($request);
		}
	}
}
