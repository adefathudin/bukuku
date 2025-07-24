<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;

Route::middleware(['role'])->group(function () {

    Route::get('/kategori', [KategoriController::class, 'list'])->name('kategori.list');
    Route::get('/transaksi/datatable', [TransaksiController::class, 'dataTable'])->name('transaksi.list.datatable');
    Route::get('/transaksi/chart/{tipe}/{filter}', [TransaksiController::class, 'chart'])->name('transaksi.chart');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    Route::get('/kategori/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::post('/kategori', [KategoriController::class, 'save'])->name('kategori.save');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/users', [UsersController::class, 'list'])->name('users.list');
    Route::get('/users/detail', [UsersController::class, 'detail'])->name('users.detail');
    Route::post('/users/save', [UsersController::class, 'save'])->name('users.save');
    Route::delete('/users/delete/{id}', [UsersController::class, 'delete'])->name('users.delete');
});
