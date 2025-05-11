<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;

Route::get('/products', [ProductsController::class, 'list'])->name('product.list');
Route::get('/products-datatable', [ProductsController::class, 'listDataTable'])->name('product.list.datatable');
Route::post('/product', [ProductsController::class, 'show'])->name('product.show');
Route::post('/product/save', [ProductsController::class, 'store'])->name('product.store');
Route::delete('/product/delete', [ProductsController::class, 'destroy'])->name('product.delete');
Route::post('/product/update', [ProductsController::class, 'update'])->name('product.update');

Route::put('/product/update', [ProductsController::class, 'update'])->name('product.update');
Route::post('/transaction/save', [TransactionsController::class, 'store'])->name('transaction.store');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
