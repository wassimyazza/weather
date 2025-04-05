<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PainterController;
use App\Http\Controllers\TableauController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPainterController;
use App\Http\Controllers\Admin\AdminTableauController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCustomOrderController;

// Front-end routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/custom-order', [CustomOrderController::class, 'showForm'])->name('custom-order');

// Tableau routes
Route::get('/tableaux/{tableau}', [TableauController::class, 'show'])->name('tableaux.show');

// Painter routes
Route::get('/artists', [PainterController::class, 'index'])->name('painters.all');
Route::resource('painters', PainterController::class);

// Cart routes
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/confirmation/{id}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Custom order routes
Route::post('/custom-order', [CustomOrderController::class, 'store'])->name('custom-order.store');
Route::get('/custom-order/confirmation/{id}', [CustomOrderController::class, 'confirmation'])->name('custom-order.confirmation');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Tableaux management
        Route::resource('tableaux', AdminTableauController::class)->parameters([
            'tableaux' => 'tableau'
        ]);
        
        // Tableau images management
        Route::delete('tableaux/images/{image}', [AdminTableauController::class, 'deleteImage'])->name('tableaux.images.delete');
        Route::post('tableaux/images/{image}/primary', [AdminTableauController::class, 'setPrimaryImage'])->name('tableaux.images.primary');
        
        // Categories management
        Route::resource('categories', AdminCategoryController::class);
        
        // Orders management
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        
        // Painters Management
        Route::resource('painters', AdminPainterController::class);

        // Custom Orders management
        Route::get('custom-orders', [AdminCustomOrderController::class, 'index'])->name('custom-orders.index');
        Route::patch('custom-orders/{customOrder}/status', [AdminCustomOrderController::class, 'updateStatus'])->name('custom-orders.update-status');
        Route::delete('custom-orders/{customOrder}', [AdminCustomOrderController::class, 'destroy'])->name('custom-orders.destroy');
    });
});