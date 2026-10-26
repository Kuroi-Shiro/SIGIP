<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\MovimientoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categorias', CategoriaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('movimientos', MovimientoController::class)->except('destroy');
Route::patch(
    '/movimientos/{movimiento}/cancelar',
    [MovimientoController::class, 'cancelar']
)->name('movimientos.cancelar');

