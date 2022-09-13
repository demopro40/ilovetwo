<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class CheckStatus
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
        if(Session::has('username') && Session::get('username') == 'Luke'){
            return $next($request);
        }
        if(env('TEST')){
            return redirect('/date/logout');
        }
        return $next($request);
    }
}
