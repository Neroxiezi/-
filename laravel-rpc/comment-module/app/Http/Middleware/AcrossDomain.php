<?php

namespace App\Http\Middleware;

use Closure;

class AcrossDomain
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type,Access-Token,x-csrf-token,x-requested-with");
        header("Access-Control-Expose-Headers: *");

        return $next($request);
    }
}
