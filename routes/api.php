<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\UserController;     
use App\Http\Controllers\ReportController;   

// ==========================================
Route::post('/login', [AuthController::class, 'login']);

// ==========================================
// 2. مسارات تتطلب تسجيل دخول عام (Auth)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // تسجيل الخروج وتحديث الملف الشخصي
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile/update', [AuthController::class, 'updateProfile']);
    
    // عرض المنيو متاح لكل الموظفين
    Route::get('/menu', [MenuController::class, 'index']);
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
    Route::apiResource('menu-items', MenuItemController::class)->only(['index', 'show']);

    // ------------------------------------------
    //  صلاحيات المدير (Admin)
    // ------------------------------------------
    Route::middleware('role:admin')->group(function () {
        // إدارة الموظفين
        Route::apiResource('users', UserController::class);
        
        // إدارة المنيو بالكامل
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        Route::apiResource('menu-items', MenuItemController::class)->except(['index', 'show']);
        
        // إدارة الطاولات بالكامل
        Route::apiResource('tables', TableController::class);
        
        // التقارير المالية
        Route::get('/reports/financial', [ReportController::class, 'financial']);
    });

    // ------------------------------------------
    //  صلاحيات الويتر (Waiter)
    // ------------------------------------------
    Route::middleware('role:waiter')->group(function () {
        Route::get('/tables', [TableController::class, 'index']); 
        Route::put('/tables/{id}/status', [TableController::class, 'updateStatus']); 
        Route::put('/tables/{id}/assign', [TableController::class, 'assignWaiter']); 
        Route::patch('/orders/{id}/serve', [App\Http\Controllers\OrderController::class, 'serveOrder']);
        // إدارة الطلبات
        Route::get('/orders/active', [OrderController::class, 'waiterOrders']); 
        Route::post('/orders', [OrderController::class, 'store']); 
        Route::post('/orders/{id}/items', [OrderController::class, 'addItem']); 
        Route::delete('/orders/{order_id}/items/{item_id}', [OrderController::class, 'removeItem']); 
    });

    // ------------------------------------------
    //  صلاحيات المطبخ (Kitchen)
    // ------------------------------------------
    Route::middleware('role:kitchen')->group(function () {
        Route::get('/kitchen/orders', [KitchenController::class, 'activeOrders']);
        Route::put('/kitchen/orders/{id}/status', [KitchenController::class, 'updateStatus']);
    });

    // ------------------------------------------
    //  صلاحيات الكاشير (Cashier)
    // ------------------------------------------
    Route::middleware('role:cashier')->group(function () {
        Route::get('/cashier/orders', [OrderController::class, 'unpaidOrders']); 
        Route::get('/invoices/{order_id}', [InvoiceController::class, 'generateInvoice']); 
        Route::post('/invoices/{order_id}/pay', [InvoiceController::class, 'processPayment']); 
    });
});