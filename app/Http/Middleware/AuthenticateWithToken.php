<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthenticateWithToken
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
