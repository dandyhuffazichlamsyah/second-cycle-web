<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SystemSettingsController as AdminSystemSettingsController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================================================
// PUBLIC ROUTES (No authentication required)
// ============================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Google OAuth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

// ============================================================================
// CUSTOMER ROUTES (Customer only - Admin will be redirected to admin panel)
// ============================================================================
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/workshops', [PageController::class, 'workshops'])->name('workshops');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
});

// Profile Routes (All authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Order Routes (Customer)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{product}', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/calculate-credit', [OrderController::class, 'calculateCredit'])->name('orders.calculate-credit');
    
    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// ============================================================================
// ADMIN ROUTES (Manager, Admin, CEO only - Completely separate from customer)
// ============================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'getStats'])->name('dashboard.stats');
    
    // Contact Messages CRUD (Manager, Admin, CEO)
    Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts');
    Route::get('/contacts/export', [ContactMessageController::class, 'export'])->name('contacts.export');
    Route::get('/contacts/unread-count', [ContactMessageController::class, 'getUnreadCount'])->name('contacts.unread-count');
    Route::get('/contacts/{message}', [ContactMessageController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{message}/reply', [ContactMessageController::class, 'reply'])->name('contacts.reply');
    Route::post('/contacts/{message}/toggle-read', [ContactMessageController::class, 'toggleRead'])->name('contacts.toggle-read');
    Route::delete('/contacts/{message}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');
    
    // Products CRUD (Manager, Admin, CEO)
    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/export', [AdminProductController::class, 'export'])->name('products.export');
    Route::get('/products/stats', [AdminProductController::class, 'getStats'])->name('products.stats');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
    
    // User Management (Admin, CEO only)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/export', [AdminUserController::class, 'export'])->name('users.export');
    Route::get('/users/stats', [AdminUserController::class, 'getStats'])->name('users.stats');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    
    // CEO-only routes
    Route::middleware(['ceo'])->group(function () {
        Route::get('/system-settings', [AdminSystemSettingsController::class, 'index'])->name('system-settings');
        Route::put('/system-settings', [AdminSystemSettingsController::class, 'update'])->name('system-settings.update');
        Route::post('/system-settings/clear-cache', [AdminSystemSettingsController::class, 'clearCache'])->name('system-settings.clear-cache');
        Route::post('/system-settings/backup', [AdminSystemSettingsController::class, 'backupDatabase'])->name('system-settings.backup');
        Route::get('/system-settings/stats', [AdminSystemSettingsController::class, 'getSystemStats'])->name('system-settings.stats');
        
        Route::get('/audit-log', function () {
            return view('admin.audit-log');
        })->name('audit-log');
    });
});

require __DIR__.'/auth.php';
