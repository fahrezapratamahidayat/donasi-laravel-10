<?php

use App\Http\Controllers\ProfileController;
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

// Route untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        $totalCampaigns = \App\Models\Donasi::count();
        $activeCampaigns = \App\Models\Donasi::where('status', 'active')->count();
        $pendingCampaigns = \App\Models\Donasi::where('status', 'pending')->count();
        $totalDonations = \App\Models\DonasiDetail::where('status_pembayaran', 'settlement')->sum('jumlah_donasi');
        $recentCampaigns = \App\Models\Donasi::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCampaigns',
            'activeCampaigns',
            'pendingCampaigns',
            'totalDonations',
            'recentCampaigns'
        ));
    })->name('dashboard');

    // Route khusus admin lainnya
    Route::get('/admin/donasi', [AdminDonasiController::class, 'index'])->name('admin.donasi.index');
    Route::get('/admin/donasi/{id}', [AdminDonasiController::class, 'show'])->name('admin.donasi.show');
    Route::post('/admin/donasi/{id}/verify', [AdminDonasiController::class, 'verify'])->name('admin.donasi.verify');
});

// Route untuk semua pengunjung
Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');

// Route untuk user yang sudah login
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/donasi/create', [DonasiController::class, 'create'])->name('donasi.create');
    Route::post('/donasi', [DonasiController::class, 'store'])->name('donasi.store');
    Route::get('/donasi/my', [DonasiController::class, 'myDonasi'])->name('donasi.my');
    Route::post('/donasi/{id}/donate', [DonasiController::class, 'donate'])->name('donasi.donate');
    Route::get('/donasi-payment/{id}', [DonasiController::class, 'payment'])->name('donasi.payment');
    Route::get('/donasi/{id}/amount', [DonasiController::class, 'amount'])->name('donasi.amount');
});

// Route show harus di bawah route create dan my
Route::get('/donasi/{id}', [DonasiController::class, 'show'])->name('donasi.show');

// Route untuk semua user yang sudah login (admin & user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tambahkan route ini di luar middleware auth
Route::post('/midtrans-webhook', [DonasiController::class, 'handleWebhook'])->name('midtrans.webhook');

require __DIR__.'/auth.php';
