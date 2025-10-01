<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\FeedbackController;

// Landing Page Route
Route::get('/', function () {
    return view('welcome'); // Halaman landing page
})->name('home');

// Auth Routes (pastikan GET login & register tidak di-protect middleware auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/admin/buku/create', [AdminController::class, 'createBuku'])->name('admin.buku.create');
    Route::post('/admin/buku', [BukuController::class, 'store'])->name('admin.buku.store'); // Make sure this is BukuController@store
    Route::get('/admin/buku/{buku}/edit', [AdminController::class, 'editBuku'])->name('admin.buku.edit');
    Route::put('/admin/buku/{buku}', [AdminController::class, 'updateBuku'])->name('admin.buku.update');
    Route::delete('/admin/buku/{buku}', [AdminController::class, 'destroyBuku'])->name('admin.buku.destroy');
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/admin/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasi'])->name('admin.peminjaman.konfirmasi');
    Route::post('/admin/peminjaman/{id}/selesai', [PeminjamanController::class, 'selesai'])->name('admin.peminjaman.selesai');
    Route::post('/update-profile', [AdminController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
});

// Siswa Routes
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/siswa/buku', function () {
        $bukus = \App\Models\Buku::all();
        return view('siswa.buku.index', compact('bukus'));
    })->name('siswa.buku.index');
    Route::post('/siswa/buku/{id}/pinjam', [PeminjamanController::class, 'pinjam'])->name('siswa.buku.pinjam');
    // Add new route for favorites
    Route::get('/siswa/favorites', [SiswaController::class, 'favorites'])->name('siswa.favorites');
    Route::post('/siswa/buku/{id}/favorite', [SiswaController::class, 'toggleFavorite'])->name('siswa.toggleFavorite');
    // Route::get('/siswa/riwayat', [SiswaController::class, 'riwayat'])->name('siswa.riwayat');
    // Tambahkan route update profil siswa
    Route::post('/siswa/update-profile', [SiswaController::class, 'updateProfile'])->name('siswa.updateProfile');
    Route::post('/siswa/peminjaman/{id}/selesai', [PeminjamanController::class, 'selesaiSiswa'])->name('siswa.peminjaman.selesai');
});

// Feedback Routes
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
