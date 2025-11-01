<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman sukses login
Route::get('/login-success', function () {
    return view('login_success');
})->name('login.success');

// Google Auth routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Make sure these routes are not duplicated elsewhere in your routes files
// Also verify that this callback URL matches exactly what's registered in Google Console:
// http://127.0.0.1:8000/auth/google/callback
