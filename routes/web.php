<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Visitor as Visitor;
use App\Http\Controllers\Cashier as Cashier;

// Router Visitor
Route::get('/', [Visitor\HomeController::class, 'index']);
Route::get('/products', [Visitor\ProductController::class, 'index']);
Route::get('/products/category/{category}', [Visitor\ProductController::class, 'byCategory']);

// Router Cashier
Route::get('/cashier', [Cashier\DashboardController::class, 'index']);
Route::get('/cashier/inventory', [Cashier\InventoryController::class, 'index']);
Route::get('/cashier/sales', [Cashier\TransactionController::class, 'sale']);
Route::delete('/cashier/sales/remove-product', [Cashier\TransactionController::class, 'removeSaleProduct']);
Route::post('/cashier/sales/scan-product', [Cashier\TransactionController::class, 'scanProduct']);
