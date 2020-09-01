<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsSuperAdmin
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->isSuperAdmin) {
            return $next($request);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
