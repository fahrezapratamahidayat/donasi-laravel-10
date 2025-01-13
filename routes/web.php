<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDonasiController;
use App\Http\Controllers\DonasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $campaigns = \App\Models\Donasi::where('status', 'active')
        ->where('is_verified', true)
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact('campaigns'));
})->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDonasiController::class, 'index'])->name('dashboard');
    Route::get('/donasi', [AdminDonasiController::class, 'index'])->name('donasi.index');
    Route::get('/donasi/{id}', [AdminDonasiController::class, 'show'])->name('donasi.show');
    Route::post('/donasi/{id}/verify', [AdminDonasiController::class, 'verify'])->name('donasi.verify');
    Route::resource('/users', UsersController::class);
});
Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/donasi/create', [DonasiController::class, 'create'])->name('donasi.create');
    Route::post('/donasi', [DonasiController::class, 'store'])->name('donasi.store');
    Route::get('/donasi/my', [DonasiController::class, 'myDonasi'])->name('donasi.my');
    Route::post('/donasi/{id}/donate', [DonasiController::class, 'donate'])->name('donasi.donate');
    Route::get('/donasi-payment/{id}', [DonasiController::class, 'payment'])->name('donasi.payment');
    Route::get('/donasi/{id}/amount', [DonasiController::class, 'amount'])->name('donasi.amount');
});

Route::get('/donasi/{id}', [DonasiController::class, 'show'])->name('donasi.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/midtrans-webhook', [DonasiController::class, 'handleWebhook'])->name('midtrans.webhook');

require __DIR__.'/auth.php';
