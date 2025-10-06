<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\EspacioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📦 MÓDULO DE ENTRADAS
    Route::get('/entradas', [EntradaController::class, 'index'])->name('entradas.index');
    Route::get('/entradas/create', [EntradaController::class, 'create'])->name('entradas.create');
    Route::post('/entradas', [EntradaController::class, 'store'])->name('entradas.store');
    Route::post('/entradas/{id}/finalizar', [EntradaController::class, 'finalizar'])->name('entradas.finalizar');

    // 📦 MÓDULO DE SALIDAS
    Route::get('/salidas', [SalidaController::class, 'index'])->name('salidas.index');
    Route::post('/salidas', [SalidaController::class, 'store'])->name('salidas.store');

    // 📦 MÓDULO DE VEHÍCULOS
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');


    Route::post('/espacios', [EspacioController::class, 'store'])->name('espacios.store');
    Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index'); // opcional
    Route::resource('espacios', EspacioController::class)->except(['show']);
});

require __DIR__ . '/auth.php';



require __DIR__ . '/auth.php';
