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
        if(env('TEST') || !(date('w',time()) == 5 && date('H',time()) >= 19)){
            return redirect('/date/logout');
        }
        return $next($request);
    }
}
