<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPetugas
{
    public function handle($request, Closure $next)
{
    if (Auth::guard('petugas')->check() &&
        Auth::guard('petugas')->user()->level === 'petugas')
    {
        return $next($request);
    }

    abort(403, 'Akses ditolak, hanya petugas yang boleh.');
}

}
