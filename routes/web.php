<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CheckinController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\AuthController as OrganizerAuthController;
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthController as CustomerAuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrganizerProfileController;

// ─── USER AREA ────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/penyelenggara/{organizer:slug}', [OrganizerProfileController::class, 'show'])->name('organizer.profile');

Route::middleware('auth')->group(function () {
    Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
     Route::get('/tiket-saya', [EventController::class, 'myTickets'])->name('tickets.mine'); // ⬅️ baru

    });

Route::get('/my-ticket/{transaction}', [EventController::class, 'ticket'])->name('ticket');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');

Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect()->route('home');
})->name('logout');

// ─── ADMIN AREA ───────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('events', AdminEventController::class);
        Route::resource('partners', PartnerController::class);

        Route::get('organizers', [OrganizerController::class, 'index'])->name('organizers.index');
        Route::patch('organizers/{organizer}/approve', [OrganizerController::class, 'approve'])->name('organizers.approve');
        Route::delete('organizers/{organizer}/reject', [OrganizerController::class, 'reject'])->name('organizers.reject');

        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::patch('transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])
            ->name('transactions.updateStatus');

        // ─── Check-in Scanner (Sistem Penjaga Pintu) ───
        Route::get('checkin', [CheckinController::class, 'index'])->name('checkin.index');
        Route::post('checkin/scan', [CheckinController::class, 'scan'])->name('checkin.scan');
    });

});

// ─── ORGANIZER AREA ───────────────────────────────────────────
Route::prefix('organizer')->name('organizer.')->group(function () {

    Route::get('register', [OrganizerAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [OrganizerAuthController::class, 'register'])->name('register.post');
    Route::get('login', [OrganizerAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [OrganizerAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [OrganizerAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('pending', [OrganizerAuthController::class, 'pending'])->name('pending');
    });

    Route::middleware(['auth', 'organizer'])->group(function () {
        Route::get('dashboard', [OrganizerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', OrganizerEventController::class)->except(['show']);
    });
});

Route::resource('jabatan', JabatanController::class);
Route::resource('pengurus', PengurusController::class)->parameters([
    'pengurus' => 'pengurus',
]);