<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/', [WelcomeController::class, 'index'])->name('homepage.index');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get("/register", [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
route::post("/register", [AuthController::class, 'register'])->middleware('guest');

// Google Authentication
Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);

// Route::get('login/facebook', [AuthController::class, 'redirectToFacebook']);
// Route::get('login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);


Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
    Route::post('/profile/picture', [AuthController::class, 'updateProfilePicture'])->name('profile.picture.update');
});

Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('categories', CategoryController::class);
Route::resource('stocks', StockController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('staffs', StaffController::class);
Route::resource('sales', SaleController::class);

Route::get('/product/detail', [ProductController::class, 'showDetail'])->name('product.detail');
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/sales_reports/generate', [SalesReportController::class, 'generateReports'])->name('sales_reports.generate');
Route::resource('sales_reports', SalesReportController::class)->only(['index', 'show']);


Route::get('orders/{order}/payment', [PaymentController::class, 'create'])->name('payments.create');
Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
