<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoketController;
use App\Http\Controllers\Api\AntrianController;
use App\Http\Controllers\Api\AuthController;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    
    // Loket routes
    Route::get('/lokets', [LoketController::class, 'index']);
    Route::post('/lokets', [LoketController::class, 'store']);
    Route::get('/lokets/{loket}', [LoketController::class, 'show']);
    Route::put('/lokets/{loket}', [LoketController::class, 'update']);
    Route::delete('/lokets/{loket}', [LoketController::class, 'destroy']);
    
    // Antrian routes
    Route::post('/lokets/{loket}/antrians/generate', [AntrianController::class, 'generate']);
    Route::put('/antrians/{antrian}/status', [AntrianController::class, 'updateStatus']);
    Route::get('/antrians/dipanggil', [AntrianController::class, 'currentCalled']);
    Route::get('/lokets/{loket}/antrians/menunggu', [AntrianController::class, 'listWaiting']);
});