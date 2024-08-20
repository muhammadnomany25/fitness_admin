<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OptionalAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            try {
                if (Auth::guard('sanctum')->user()) {
                    Auth::setUser(
                        Auth::guard('sanctum')->user()
                    );
                } else {
                    return response()->json(null, 401);
                }

            } catch (\Exception $exception) {
                return response()->json(null, 401);
            }
        }
        return $next($request);
    }
}
