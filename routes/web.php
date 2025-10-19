<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Livewire\OrderReceiver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::aliasMiddleware('role', RoleMiddleware::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [MenuController::class, 'guestIndex'])->name('menu.list');
Route::get('/cart', function() {
    return view('guest.cart');
})->name('guest.cart');

Route::get('order/{orderId}', function ($orderId) {
    return view('guest.order', ['orderId' => $orderId]);
})->name('guest.order');


Route::get('/test-session', function () {
    return session()->getId();
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;


Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->name('login');
	Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Routes for all authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard / Profile
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Foodtruck section (order & menu quick toggle)
    Route::get('/cashier/orders', function() {
        return view('cashier.order');
    })->name('cashier.order');
    Route::get('/cashier/menus', function() {
        return view('cashier.menu');
    })->name('cashier.menu');
});

// Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    // User management
    Route::resource('users', UserController::class);
});

// Admin + User
Route::middleware(['auth', 'role:admin,user'])->group(function () {
    // Menu management
    Route::get('/menu-list', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu-add', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Completed Orders
    Route::get('/order-list', [OrderController::class ,'index'])->name('order.index');
    Route::get('/order-list/{id}', [OrderController::class, 'show'])->name('order.show');
});
