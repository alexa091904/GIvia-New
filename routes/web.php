<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

// ============= DEBUG ROUTES =============
Route::get('/debug-views', function() {
    // ... same as before ...
});

// ============= AUTHENTICATION ROUTES =============
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// ============= PUBLIC ROUTES =============
Route::get('/', function () {
    $featuredProducts = \App\Models\Product::latest()->take(4)->get();
    return view('welcome', compact('featuredProducts'));
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::redirect('/shop', '/products');

// Product routes - public viewing
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Create route must come before the show route with {id}
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/api/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/api/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/api/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');

// ============= AUTHENTICATED ROUTES =============
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ============= ADMIN ROUTES (Product creation using regular ProductController) =============
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});

// ============= ADMIN PREFIX ROUTES (existing Admin controllers) =============
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('/products', AdminProductController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/{product}/adjust', [AdminInventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/export/csv', [AdminUserController::class, 'export'])->name('users.export');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/users/{user}/clear-cart', [AdminUserController::class, 'clearCart'])->name('users.clear-cart');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/inventory', [AdminReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/general', [AdminSettingsController::class, 'updateGeneral'])->name('settings.general');
    Route::post('/settings/payment', [AdminSettingsController::class, 'updatePayment'])->name('settings.payment');
    Route::post('/settings/shipping', [AdminSettingsController::class, 'updateShipping'])->name('settings.shipping');
    Route::post('/settings/cache', [AdminSettingsController::class, 'clearCache'])->name('settings.cache');
});

// ============= TESTING ROUTES (keep as is) =============
// ... all your existing testing routes (/list-views, /force-products, /make-admin, etc.) ...

Route::get('/setup-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        return 'Database migrated and seeded successfully! You can now go back to your website.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});