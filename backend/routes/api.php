<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController; // <--- AGREGA ESTA LÍNEA
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('productos', ProductoController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ahora estas líneas ya no darán error porque el controlador está importado arriba
Route::apiResource('categorias', CategoriaController::class);
Route::get('categorias/{categoria}/productos', [CategoriaController::class, 'productos']);