<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToRegisterIfGuest
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() === null) {
            return redirect()->route('user.create');
        }

        return $next($request);
    }
}
