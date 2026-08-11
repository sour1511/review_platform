<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $configured = config('services.api.key');
        if (empty($configured)) {
            return response()->json([
                'status' => 'failure',
                'message' => 'API is disabled',
            ], 503);
        }

        $provided = $request->header('X-Api-Key') ?: $request->input('api_key');
        if (!hash_equals((string) $configured, (string) $provided)) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
