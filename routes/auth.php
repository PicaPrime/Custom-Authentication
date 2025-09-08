<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');


Route::get('/register', function () {
    return view('auth.register');
})->middleware(RedirectIfAuthenticated::class)->name('register');


Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest') ->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
