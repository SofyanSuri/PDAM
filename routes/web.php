<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengaduanController;

// Import middleware class langsung (FQCN)
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsPelanggan;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Setelah login, arahkan ke dashboard sesuai role
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'pelanggan') {
        return redirect()->route('pelanggan.dashboard');
    }
    abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup untuk user yang sudah login dan terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --------------------------
    // ADMIN ONLY (gunakan FQCN)
    // --------------------------
    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/pengaduan-firebase', [AdminController::class, 'dataFirebase'])->name('admin.firebase');
        Route::patch('/admin/pengaduan/{id}/update-status', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    });


    // --------------------------
    // PELANGGAN ONLY (gunakan FQCN)
    // --------------------------
    Route::middleware([IsPelanggan::class])->group(function () {
        Route::get('/pelanggan/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    });
});

require __DIR__.'/auth.php';
