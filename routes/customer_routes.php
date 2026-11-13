<?php

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/customer/login', [CustomerAuthController::class, 'showLogin'])
        ->name('customer.login');
    Route::post('/customer/login', [CustomerAuthController::class, 'login'])
        ->name('customer.login.submit');

    Route::get('/customer/register', [CustomerAuthController::class, 'showRegister'])
        ->name('customer.register');
    Route::post('/customer/register', [CustomerAuthController::class, 'register'])
        ->name('customer.register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
        ->name('customer.dashboard');
    Route::get('/dashboard/pesanan/{id}', [CustomerDashboardController::class, 'show'])
        ->name('customer.orders.show');
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])
        ->name('customer.logout');
});
