<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;

Route::middleware(['role'])->group(function () {
    Route::get('/products', [ProductsController::class, 'list'])->name('product.list');
    Route::get('/products-datatable', [ProductsController::class, 'listProductsDataTable'])->name('product.list.datatable');
    Route::get('/products-transaction', [ProductsController::class, 'listProductsTransaction'])->name('product.list.transaction');
    Route::post('/product', [ProductsController::class, 'showById'])->name('product.show');
    // Route::post('/product/save', [ProductsController::class, 'store'])->name('product.store');
    Route::delete('/product/delete', [ProductsController::class, 'destroy'])->name('product.delete');
    Route::post('/product/save', [ProductsController::class, 'save'])->name('product.save');
    Route::get('/product/categories', [ProductsController::class, 'getCategories'])->name('product.categories');
    Route::get('/product/subcategories', [ProductsController::class, 'getSubCategories'])->name('product.subcategories');
    Route::get('/product/subcategories/{categoryId}', [ProductsController::class, 'getSubCategories'])->name('product.subcategories');

    // Route::put('/product/update', [ProductsController::class, 'update'])->name('product.update');
    Route::post('/transaction/save', [TransactionsController::class, 'store'])->name('transaction.store');

    Route::get('/reports/datatable', [ReportsController::class, 'dataTable'])->name('transaction.list.datatable');
    Route::get('/reports/chart/{type}/{filter}/{range}', [ReportsController::class, 'chart'])->name('reports.chart');

    Route::get('/users', [UsersController::class, 'list'])->name('users.list');
    Route::post('/users/save', [UsersController::class, 'save'])->name('users.save');
});
