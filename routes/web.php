<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UsersController;

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/users/profile', [UsersController::class, 'profile'])->name('users.profile');
});
Route::get('/login', function () { return view('auth.login');})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
