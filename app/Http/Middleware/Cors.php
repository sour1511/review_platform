<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Do not reflect Access-Control-Allow-Origin: * on credentialed app traffic.
 * Prefer Laravel's HandleCors + config/cors.php for API needs.
 */
class Cors
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
