<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Reutiliza la lógica de roles
        if (!Auth::check() || !Auth::user()->roles->pluck('name')->contains('admin')) {
            abort(403, 'Acceso denegado. Solo administradores.');
        }

        return $next($request);
    }
}
