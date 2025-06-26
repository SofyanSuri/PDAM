<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPelanggan
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'pelanggan') {
            return $next($request);
        }

        abort(403, 'Akses hanya untuk pelanggan.');
    }
}
