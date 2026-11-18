<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// El login (GET/POST /login) y el logout (POST /logout) los registra Fortify.

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard');

    # CATEGORIAS
    Route::resource('categorias', CategoriaController::class);
    Route::patch('/categorias/{categoria}/archivar', [CategoriaController::class, 'archivar'])
        ->name('categorias.archivar');
    Route::patch('/categorias/{categoria}/restaurar', [CategoriaController::class, 'restaurar'])
        ->name('categorias.restaurar');
#PRODUCTOS
Route::resource('productos', ProductoController::class);
Route::patch(
    '/productos/{producto}/archivar',
    [ProductoController::class, 'archivar']
)->name('productos.archivar');
Route::patch(
    '/productos/{producto}/restaurar',
    [ProductoController::class, 'restaurar']
)->name('productos.restaurar');

    # PRODUCTOS
    Route::resource('productos', ProductoController::class);
    Route::patch('/productos/{producto}/archivar', [ProductoController::class, 'archivar'])
        ->name('productos.archivar');
    Route::patch('/productos/{producto}/restaurar', [ProductoController::class, 'restaurar'])
        ->name('productos.restaurar');

    # PROVEEDORES (el singular en inglés de "proveedores" sería "proveedore", por eso se fuerza el nombre)
    Route::resource('proveedores', ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor']);
    Route::patch('/proveedores/{proveedor}/archivar', [ProveedorController::class, 'archivar'])
        ->name('proveedores.archivar');

    # USUARIOS
    Route::resource('usuarios', UsuarioController::class);
    Route::patch('/usuarios/{usuario}/archivar', [UsuarioController::class, 'archivar'])
        ->name('usuarios.archivar');

    # ENTREGAS
    Route::resource('entregas', EntregaController::class);

    # MOVIMIENTOS
    Route::resource('movimientos', MovimientoController::class)->except('destroy');
    Route::patch('/movimientos/{movimiento}/cancelar', [MovimientoController::class, 'cancelar'])
        ->name('movimientos.cancelar');
});
