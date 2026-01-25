<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HistoriesController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\EventController as UserEventController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Histories (Riwayat Pembelian)
    Route::get('/history', [App\Http\Controllers\User\HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{order}', [App\Http\Controllers\User\HistoryController::class, 'show'])->name('history.show');

    // Checkout
    Route::post('/checkout', [App\Http\Controllers\User\CheckoutController::class, 'store'])->name('checkout.store');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Category Management
        Route::resource('categories', CategoryController::class);

        // Event Management
        Route::resource('events', EventController::class);

        // Tiket Management 
        Route::resource('tickets', TiketController::class);

        // Histories
        Route::get('/histories', [HistoriesController::class, 'index'])->name('histories.index');
        Route::get('/histories/{id}', [HistoriesController::class, 'show'])->name('histories.show');

        // Payment Types
        Route::resource('payment-types', App\Http\Controllers\Admin\PaymentTypeController::class);
    });
});


require __DIR__ . '/auth.php';
