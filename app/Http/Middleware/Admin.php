<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Admin
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
        $user_role = Session::get('user_role');

        if ($user_role != 1) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}
