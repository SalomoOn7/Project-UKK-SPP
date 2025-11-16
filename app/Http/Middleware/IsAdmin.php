<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level === 'admin') {
            return $next($request);
        }

        abort(403, 'Akses ditolak, hanya admin yang boleh.');
    }
}
