<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class EnsureFrontendUser
{
    public function handle(Request $request, Closure $next)
    {
        if (empty(Session::get('login_user_id'))) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
            }

            return redirect()->route('user_login_page');
        }

        return $next($request);
    }
}
