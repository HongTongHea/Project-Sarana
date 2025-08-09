<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductpageController;
use App\Http\Controllers\AccessorypageController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');
Route::get('/productpage', [ProductpageController::class, 'index'])->name('productpage.index');
Route::get('/accessorypage', [AccessorypageController::class, 'index'])->name('accessorypage.index');

/*
|--------------------------------------------------------------------------
| Auth (guest) routes - accessible only when NOT authenticated as admin OR customer
|--------------------------------------------------------------------------
*/
Route::middleware('guest:admin,customer')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


    // // Google Authentication (if used)
    // Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect']);
    // Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
});


Route::middleware('guest')->group(function () {
    Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

/*
|--------------------------------------------------------------------------
| Logout (single route) - accessible even if guard varies (controller will handle)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated routes for either admin OR customer (shared website features)
| Use auth:admin,customer so either logged-in admin OR customer can access.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin,customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/profile/picture', [AuthController::class, 'updateProfilePicture'])->name('profile.picture.update');

    // Orders / shopping features that both can use (if applicable)
    // Route::resource('orders', OrderController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('orders/search-products', [OrderController::class, 'searchProducts'])->name('orders.search-products');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/{order}/print-invoice', [OrderController::class, 'printInvoice'])->name('orders.print-invoice');
});

/*
|--------------------------------------------------------------------------
| Admin-only routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Admin resources (only admins)
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('products', ProductController::class);
    Route::resource('accessories', AccessoryController::class);
    Route::resource('orders', OrderController::class);
});
