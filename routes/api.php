<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HealthController;

// Health
Route::get('/health', [HealthController::class, 'index']);

// API V1
Route::prefix('v1')->group(function () {
    Route::apiResource('clientes', ClienteController::class);
});
