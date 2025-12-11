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
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductpageController;
use App\Http\Controllers\AllproductpageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\CheckoutOrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutpageController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');
Route::get('/productpage', [ProductpageController::class, 'index'])->name('productpage.index');
Route::get('/allproductpage', [AllproductpageController::class, 'index'])->name('allproductpage.index');
Route::get('/aboutpage', [AboutpageController::class, 'index'])->name('aboutpage.index');


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
// Profile


Route::middleware(['auth:admin,manager,cashier,customer'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/picture', [UserController::class, 'updateProfilePicture'])->name('profile.picture.update');
    // Sales
    Route::get('sales/search-products', [SaleController::class, 'searchProducts'])->name('sales.search-products');
    Route::get('sales/search-accessories', [SaleController::class, 'searchAccessories'])->name('sales.search-accessories');
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('/sales/{sale}/print-invoice', [SaleController::class, 'printInvoice'])->name('sales.print-invoice');

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
    Route::resource('sales', SaleController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchase_orders', PurchaseOrderController::class);

    Route::get('/sales-reports/top-items', [SalesReportController::class, 'topItems'])->name('sales-reports.top.items');
    Route::get('/sales-reports', [SalesReportController::class, 'index'])->name('sales-reports.index');
    Route::get('/sales-reports/{id}', [SalesReportController::class, 'show'])->name('sales-reports.show');
    Route::get('/sales-reports/{id}/data', [SalesReportController::class, 'getReportData'])->name('sales-reports.data');
    Route::post('/sales-reports/weekly', [SalesReportController::class, 'generateWeeklyReport'])->name('sales-reports.generate-weekly');
    Route::post('/sales-reports/monthly', [SalesReportController::class, 'generateMonthlyReport'])->name('sales-reports.generate-monthly');
    Route::post('/sales-reports/yearly', [SalesReportController::class, 'generateYearlyReport'])->name('sales-reports.generate-yearly');
    Route::delete('/sales-reports/{id}', [SalesReportController::class, 'destroy'])->name('sales-reports.destroy');
});


// Legacy dashboard route for backward compatibility
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');;

// Public checkout routes (accessible by all authenticated users)
Route::middleware(['auth'])->group(function () {
    // Checkout Process
    Route::get('/checkout', [CheckoutOrderController::class, 'checkout'])->name('checkout');
    Route::post('/online-orders', [CheckoutOrderController::class, 'store'])->name('online-orders.store');
    Route::get('/order-confirmation/{order}', [CheckoutOrderController::class, 'confirmation'])->name('order.confirmation');

    // Customer-facing routes (website) - for customers only
    Route::get('/my-orders', [CheckoutOrderController::class, 'myOrders'])->name('my-orders.index');
    Route::get('/my-orders/{order}', [CheckoutOrderController::class, 'myOrderShow'])->name('my-orders.show');
});

// Admin system routes (only for admin, manager, cashier)
Route::middleware(['auth:admin,manager,cashier'])->group(function () {
    Route::get('/online-orders', [CheckoutOrderController::class, 'index'])->name('online-orders.index');
    Route::get('/online-orders/{onlineOrder}', [CheckoutOrderController::class, 'show'])->name('online-orders.show');
});

// Contact routes
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin contact management routes
Route::middleware(['auth:admin,manager,cashier'])->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/admin/contacts/{contact}', [ContactController::class, 'show'])->name('contact.show');
    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');

    // Contact notification routes
    Route::get('/contacts/unread-count', [ContactController::class, 'unreadCount'])->name('contact.unread-count');
    Route::post('/admin/contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contact.mark-read');
});
