<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

// ── Rutas públicas (sin autenticación) ──────────────────────
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ── Rutas protegidas (requieren token Sanctum) ───────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',     [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('productos',  ProductoController::class);
    Route::apiResource('categorias', CategoriaController::class);

    Route::get('categorias/{categoria}/productos', [CategoriaController::class, 'productos']);
});