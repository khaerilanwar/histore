<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Visitor as Visitor;
use App\Http\Controllers\Cashier as Cashier;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

// Route Testing
Route::get('test', function () {
    return 'hello world';
})->can('isCashier');

// Router Visitor
Route::get('/', [Visitor\HomeController::class, 'index']);
Route::get('/products', [Visitor\ProductController::class, 'index']);
Route::get('/products/category/{category}', [Visitor\ProductController::class, 'byCategory']);

Route::middleware([Authenticate::class])->group(function () {
    // Router Admin
    Route::group(['middleware' => 'can:isAdmin'], function () {
        Route::get('/admin', [Admin\DashboardController::class, 'index']);
    });

    // Router Cashier
    Route::group(['middleware' => 'can:isCashier'], function () {
        Route::get('/cashier', [Cashier\DashboardController::class, 'index'])->name('cashier');
        Route::get('/cashier/inventory', [Cashier\InventoryController::class, 'index']);
        Route::get('/cashier/sales', [Cashier\TransactionController::class, 'sale']);
        Route::delete('/cashier/sales/remove-product', [Cashier\TransactionController::class, 'removeSaleProduct']);
        Route::post('/cashier/sales/scan-product', [Cashier\TransactionController::class, 'scanProduct']);
        Route::post('/cashier/sales/cek-member', [Cashier\TransactionController::class, 'cekMember']);
        Route::delete('/cashier/sales/remove-member', [Cashier\TransactionController::class, 'removeMember']);
        Route::post('/cashier/sales/finish-transaction', [Cashier\TransactionController::class, 'finishTransaction']);
        Route::get('/cashier/sales/history', [Cashier\TransactionHistoryController::class, 'index']);
        Route::get('/cashier/profile', [UserController::class, 'cashierProfile']);
        Route::post('/cashier/profile/change-password', [UserController::class, 'changePasswordCashier']);
        Route::get('/cashier/notification/{notif}', [NotificationController::class, 'detail']);
        Route::post('/cashier/notification/{notif}', [NotificationController::class, 'confirm']);
    });

    // Route Logout
    Route::delete('/authentication', [AuthenticationController::class, 'logout'])->middleware([Authenticate::class]);
});

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    // Route Authentication
    Route::get('/authentication', [AuthenticationController::class, 'index']);
    Route::post('/authentication', [AuthenticationController::class, 'login'])->name('login');
});
