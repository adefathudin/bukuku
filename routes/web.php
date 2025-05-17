<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\EnsureUserHasRole;

Route::middleware([EnsureUserHasRole::class . ':admin,kasir'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/reports', [ReportsController::class, 'index']);
    Route::get('/transaction', [TransactionsController::class, 'index']);
    Route::get('/users', [UsersController::class, 'index']);
});

Route::get('/products', [ProductsController::class, 'index'])->middleware([EnsureUserHasRole::class . ':admin']);
Route::get('/', [AuthController::class, 'index']);
Route::get('/login', function () { return view('auth.login');})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');