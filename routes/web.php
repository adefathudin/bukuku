<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Middleware\RoleMiddleware;

Route::middleware(['role'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductsController::class, 'index']);
    Route::get('/reports', [ReportsController::class, 'index']);
    Route::get('/transaction', [TransactionsController::class, 'index']);
});

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
