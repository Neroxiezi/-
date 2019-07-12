<?php

namespace App\Http\Middleware;

use Closure;

class AcrossDomain
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
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-request-with');
        $response->header('Access-Control-Allow-Methods', 'POST');
        return $response;
    }
}
