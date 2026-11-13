<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\FilmController;
use App\Http\Controllers\BookingController;

// HALAMAN PELANGGAN
Route::get('/', [FilmController::class, 'index'])->name('home');
Route::get('/film/{id}', [FilmController::class, 'show'])->name('film.show');

Route::get('/booking/{schedule_id}',
    [BookingController::class, 'create']
)->name('booking.create');

Route::post('/booking/{schedule_id}',
    [BookingController::class, 'store']
)->name('booking.store');

Route::get('/tiket/{kode_booking}',
    [BookingController::class, 'ticket']
)->name('booking.ticket');

// HALAMAN ADMIN

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Auth Routes
        Route::middleware('guest')->group(function () {
            Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
        });

        Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])
            ->middleware('auth', 'admin')
            ->name('logout');

        // Dashboard Routes (protected by admin middleware)
        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

            // Manajemen Film
            Route::resource('films', \App\Http\Controllers\Admin\FilmController::class);

            // Jadwal Tayang
            Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class);
            Route::get('/schedules/{schedule}/bookings', [\App\Http\Controllers\Admin\ScheduleController::class, 'bookings'])->name('schedules.bookings');

            // Bioskop
            Route::resource('cinemas', \App\Http\Controllers\Admin\CinemaController::class);

            // Studio
            Route::resource('studios', \App\Http\Controllers\Admin\StudioController::class);
            Route::get('/studios/{studio}/seats', [\App\Http\Controllers\Admin\StudioController::class, 'seats'])->name('studios.seats');

            // Kursi
            Route::get('/seats', [\App\Http\Controllers\Admin\SeatController::class, 'index'])->name('seats.index');
            Route::get('/seats/{studio}', [\App\Http\Controllers\Admin\SeatController::class, 'show'])->name('seats.show');

            // Pemesanan Tiket
            Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class);
            Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
            Route::get('/bookings/{booking}/detail', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
            Route::get('/bookings/{booking}/qr', [\App\Http\Controllers\Admin\BookingController::class, 'qrCode'])->name('bookings.qr');

            // Pelanggan
            Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
            Route::patch('/customers/{customer}/toggle-status', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customers.toggleStatus');

            // Laporan
            Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.pdf');
            Route::get('/reports/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportExcel'])->name('reports.excel');

            // Manajemen Admin
            Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
            Route::patch('/admins/{admin}/password', [\App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])->name('admins.updatePassword');
        });
    });

// Redirect /admin to /admin/login if not authenticated
Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
})->name('admin.index');