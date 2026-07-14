<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AuthController;

// ─── USER AREA ────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/my-ticket/{transaction}', [EventController::class, 'ticket'])->name('ticket');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');

// ─── ADMIN AREA ───────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

        Route::resource('events', AdminEventController::class);
        Route::resource('partners', PartnerController::class);

        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
        Route::patch('transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])
    ->name('transactions.updateStatus');
    }); 

}); 