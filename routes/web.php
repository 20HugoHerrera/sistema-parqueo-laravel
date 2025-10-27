<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReporteController;
use App\Models\Vehiculo;
use App\Models\Espacio;
use App\Models\User;
use App\Models\Entrada;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Dashboard general (solo usuarios autenticados)
Route::get('/dashboard', function () {
    $espacios = Espacio::where('activo', true)->get();
    $espaciosOcupados = Entrada::where('estado', 'activo')->pluck('espacio_id')->toArray();
    $espaciosDisponibles = $espacios->whereNotIn('id', $espaciosOcupados)->count();

    return view('dashboard', [
        'totalVehiculos' => Vehiculo::count(),
        'espaciosDisponibles' => $espaciosDisponibles,
        'totalUsuarios' => User::count(),
    ]);
})->middleware(['auth'])->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📥 Entradas (todos los usuarios autenticados)
    Route::get('/entradas', [EntradaController::class, 'index'])->name('entradas.index');
    Route::get('/entradas/create', [EntradaController::class, 'create'])->name('entradas.create');
    Route::post('/entradas', [EntradaController::class, 'store'])->name('entradas.store');
    Route::post('/entradas/{id}/finalizar', [EntradaController::class, 'finalizar'])->name('entradas.finalizar');
    Route::get('/entradas/filtrar', [EntradaController::class, 'filtrar'])->name('entradas.filtrar');



    // 📤 Salidas (todos los usuarios autenticados)
    Route::get('/salidas', [SalidaController::class, 'index'])->name('salidas.index');
    Route::post('/salidas', [SalidaController::class, 'store'])->name('salidas.store');
    Route::get('/salidas/filtrar', [SalidaController::class, 'filtrar'])->name('salidas.filtrar');



    //
    // 🚗 RUTAS PARA USUARIOS AUTENTICADOS (pueden ver)
    //
    Route::middleware(['auth'])->group(function () {
        Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    });

    //
    // 🔒 RUTAS SOLO PARA ADMIN (pueden crear, editar, eliminar)
    //
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/vehiculos/create', [VehiculoController::class, 'create'])->name('vehiculos.create');
        Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
        Route::get('/vehiculos/{vehiculo}/edit', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
        Route::put('/vehiculos/{vehiculo}', [VehiculoController::class, 'update'])->name('vehiculos.update');
        Route::delete('/vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');
    });
    // Usuarios (solo admin)
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::middleware(['auth','role:admin'])->group(function () {
        
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });

    // Espacios (todos los usuarios autenticados)
    Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/espacios/create', [EspacioController::class, 'create'])->name('espacios.create');
    Route::post('/espacios', [EspacioController::class, 'store'])->name('espacios.store');
    Route::get('/espacios/{espacio}/edit', [EspacioController::class, 'edit'])->name('espacios.edit');
    Route::put('/espacios/{espacio}', [EspacioController::class, 'update'])->name('espacios.update');
    Route::delete('/espacios/{espacio}', [EspacioController::class, 'destroy'])->name('espacios.destroy');
});

        // Reportes de entradas y salidas
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/pdf', [ReporteController::class, 'exportPDF'])->name('reportes.pdf');
        Route::get('reportes/export-csv', [App\Http\Controllers\ReporteController::class, 'exportExcelCsv'])->name('reportes.exportCsv');

    });

});

// Autenticación (Login / Registro / Password Reset)
require __DIR__ . '/auth.php';
