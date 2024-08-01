<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if ($request->user() && $request->user()->roles) {
            $roles = $request->user()->roles->pluck('code');

            if ($roles->contains('Admin')) {
                return $next($request);
            }
        }

        return redirect('/dashboard');
    }
}
