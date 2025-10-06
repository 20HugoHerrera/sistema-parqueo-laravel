<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            // middlewares de Laravel
        ],

        'api' => [
            // middlewares API
        ],
    ];

    /**
     * The application's route middleware.
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // 👇 aquí agregamos el nuevo middleware de roles
        'role' => \App\Http\Middleware\CheckRole::class,
    ];
}

Route::middleware(['auth', 'role:Administrador'])->group(function() {
    Route::get('/dashboard/admin', [AdminController::class, 'index']);
});
