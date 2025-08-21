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
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');
Route::get('/productpage', [ProductpageController::class, 'index'])->name('productpage.index');
Route::get('/accessorypage', [AccessorypageController::class, 'index'])->name('accessorypage.index');
Route::get('/search', [SearchController::class, 'search']);

/*
|--------------------------------------------------------------------------
| Auth (guest) routes - accessible only when NOT authenticated as admin OR customer
|--------------------------------------------------------------------------
*/
Route::middleware('guest:admin,manager,cashier,customer')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Google Authentication (if used)
    Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
});

/*
|--------------------------------------------------------------------------
| Logout (single route) - accessible even if guard varies (controller will handle)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated routes - for all roles
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin,manager,cashier,customer'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [AuthController::class, 'updateProfilePicture'])->name('profile.picture.update');

    // Orders
    Route::get('orders/search-products', [OrderController::class, 'searchProducts'])->name('orders.search-products');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/{order}/print-invoice', [OrderController::class, 'printInvoice'])->name('orders.print-invoice');

    Route::post('/purchase_orders/{purchase_order}/mark-received', [PurchaseOrderController::class, 'markAsReceived'])
        ->name('purchase_orders.markReceived');
});

/*
|--------------------------------------------------------------------------
| Role-specific dashboard routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
});

Route::middleware(['auth:manager'])->group(function () {
    Route::get('/manager/dashboard', [DashboardController::class, 'managerDashboard'])->name('manager.dashboard');
});

Route::middleware(['auth:cashier'])->group(function () {
    Route::get('/cashier/dashboard', [DashboardController::class, 'cashierDashboard'])->name('cashier.dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin, Manager, Cashier shared resources
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin,manager,cashier'])->group(function () {
    // Shared resources with role-based authorization in controllers
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('products', ProductController::class);
    Route::resource('accessories', AccessoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchase_orders', PurchaseOrderController::class);
});

// Legacy dashboard route for backward compatibility
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
