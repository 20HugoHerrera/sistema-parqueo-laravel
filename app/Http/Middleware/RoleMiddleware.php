<?php

            namespace App\Http\Middleware;
 

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante y verifica el rol.
     *
     * Uso en rutas: ->middleware('role:admin')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'No autorizado.');
        }

        // Si el usuario usa spatie/laravel-permission
        if (method_exists($user, 'hasRole')) {
            if (! $user->hasRole($role)) {
                abort(403, 'No tienes el rol necesario.');
            }
            return $next($request);
        }

        // Si el modelo User tiene un campo 'role' simple
        if (isset($user->role) && $user->role === $role) {
            return $next($request);
        }

        // Si el usuario tiene relación roles (colección) y contiene el rol por nombre
        if (isset($user->roles) && is_iterable($user->roles)) {
            foreach ($user->roles as $r) {
                if (isset($r->name) && $r->name === $role) {
                    return $next($request);
                }
            }
        }

        abort(403, 'No tienes el rol necesario.');
    }
}