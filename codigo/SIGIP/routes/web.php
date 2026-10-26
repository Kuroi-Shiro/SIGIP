<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});

#CATEGORIAS
Route::resource('categorias', CategoriaController::class);

#PRODUCTOS
Route::resource('productos', ProductoController::class);
Route::patch(
    '/productos/{producto}/archivar',
    [ProductoController::class, 'archivar']
)->name('productos.archivar');

#PROVEEDORES
Route::resource('proveedores', ProveedorController::class);

#USUARIOS
Route::resource('usuarios', UsuarioController::class);
Route::patch(
    '/usuarios/{usuario}/archivar',
    [UsuarioController::class, 'archivar']
)->name('usuarios.archivar');

#ENTREGAS
Route::resource('entregas', EntregaController::class);

#MOVIMIENTOS
Route::resource('movimientos', MovimientoController::class)->except('destroy');
Route::patch(
    '/movimientos/{movimiento}/cancelar',
    [MovimientoController::class, 'cancelar']
)->name('movimientos.cancelar');



