<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Visitor as Visitor;
use App\Http\Controllers\Cashier as Cashier;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RemoveSessionNewProduct;
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

        // Routing menu produk
        Route::get('/admin/product', [Admin\ProductController::class, 'index']);
        Route::patch('/admin/product/{product:barcode}', [Admin\ProductController::class, 'updateProduct']);
        Route::delete('/admin/product/{product:barcode}', [Admin\ProductController::class, 'removeProduct']);
        Route::get('/admin/product/add', [Admin\ProductController::class, 'addProduct']);
        Route::post('/admin/product/check', [Admin\ProductController::class, 'checkBarcode']);
        Route::post('/admin/product/new', [Admin\ProductController::class, 'storeProduct']);
        Route::get('/admin/product/in', [Admin\InProductController::class, 'index']);

        // Routing menu kategori 
        Route::get('/admin/category', [Admin\CategoryController::class, 'index']);
        Route::patch('/admin/category/{category:slug}', [Admin\CategoryController::class, 'updateCategory']);
        Route::delete('/admin/category/{category:slug}', [Admin\CategoryController::class, 'removeCategory']);
        Route::post('/admin/category', [Admin\CategoryController::class, 'storeCategory']);

        // Routing menu toko
        Route::get('/admin/shop', [Admin\ShopController::class, 'index']);
        Route::get('/admin/shop/inventory/{shop}', [Admin\ShopController::class, 'shopInventory']);
        Route::get('/admin/shop/staff/{shop}', [Admin\ShopController::class, 'shopStaff']);

        // Routing menu staff
        Route::get('/admin/staff', [StaffController::class, 'index']);
        Route::get('/admin/staff/add', [StaffController::class, 'add']);
        Route::post('/admin/staff', [StaffController::class, 'storeStaff']);
        Route::get('/admin/staff/biodata/{user:nik}', [StaffController::class, 'biodata']);
        Route::get('/admin/staff/mutasi/{user:nik}', [StaffController::class, 'mutasi']);
        Route::patch('/admin/staff/mutasi/{user:nik}', [StaffController::class, 'mutasiPatch']);
        Route::patch('/admin/staff/resign/{user:nik}', [StaffController::class, 'resign']);
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
        Route::get('/cashier/member', [Cashier\MemberController::class, 'index']);
        Route::post('/cashier/member', [Cashier\MemberController::class, 'store']);
    });

    // Route Logout
    Route::delete('/authentication', [AuthenticationController::class, 'logout'])->middleware([Authenticate::class]);
});

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    // Route Authentication
    Route::get('/authentication', [AuthenticationController::class, 'index']);
    Route::post('/authentication', [AuthenticationController::class, 'login'])->name('login');
});
