<?php

namespace App\Http\Middleware;

use Closure;

class TokenAuth
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
        $token = $request->header('X-TOKEN');
        if('test-value' != $token)
        {
            abort(401, 'Authorization Token not valid');
        }

        return $next($request);
    }
}
