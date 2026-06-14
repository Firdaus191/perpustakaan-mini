<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'authenticate'])
        ->name('login.post');

});

/*
|--------------------------------------------------------------------------
| USER (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard User
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])
        ->name('user.dashboard');

    // Daftar Buku
    Route::get('/user/buku', [UserController::class, 'buku'])
        ->name('user.buku');

    // Riwayat
    Route::get('/riwayat', [UserController::class, 'riwayat'])
        ->name('user.riwayat');

    // Pinjam Buku
    Route::post('/user/pinjam/{id}', [UserController::class, 'pinjam'])
        ->name('user.pinjam');

    // kembalikan Buku
    Route::post('/user/kembalikan/{id}', [UserController::class, 'kembalikan'])
    ->name('user.kembalikan');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */

    Route::get('/kategori', [KategoriController::class, 'index'])
        ->name('kategori.index');

    Route::get('/kategori/create', [KategoriController::class, 'create'])
        ->name('kategori.create');

    Route::post('/kategori/store', [KategoriController::class, 'store'])
        ->name('kategori.store');

    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])
        ->name('kategori.edit');

    Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])
        ->name('kategori.update');

    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'delete'])
        ->name('kategori.delete');

    /*
    |--------------------------------------------------------------------------
    | BUKU
    |--------------------------------------------------------------------------
    */

    Route::get('/buku', [BukuController::class, 'index'])
        ->name('buku.index');

    Route::get('/buku/create', [BukuController::class, 'create'])
        ->name('buku.create');

    Route::post('/buku/store', [BukuController::class, 'store'])
        ->name('buku.store');

    Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])
        ->name('buku.edit');

    Route::post('/buku/update/{id}', [BukuController::class, 'update'])
        ->name('buku.update');

    Route::delete('/buku/delete/{id}', [BukuController::class, 'delete'])
        ->name('buku.delete');

    /*
    |--------------------------------------------------------------------------
    | ANGGOTA
    |--------------------------------------------------------------------------
    */

    Route::get('/anggota', [AnggotaController::class, 'index'])
        ->name('anggota.index');

    Route::get('/anggota/create', [AnggotaController::class, 'create'])
        ->name('anggota.create');

    Route::post('/anggota/store', [AnggotaController::class, 'store'])
        ->name('anggota.store');

    Route::get('/anggota/edit/{id}', [AnggotaController::class, 'edit'])
        ->name('anggota.edit');

    Route::post('/anggota/update/{id}', [AnggotaController::class, 'update'])
        ->name('anggota.update');

    Route::delete('/anggota/delete/{id}', [AnggotaController::class, 'delete'])
        ->name('anggota.delete');

    /*
    |--------------------------------------------------------------------------
    | PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
        ->name('peminjaman.create');

    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

    Route::get('/peminjaman/edit/{id}', [PeminjamanController::class, 'edit'])
        ->name('peminjaman.edit');

    Route::post('/peminjaman/update/{id}', [PeminjamanController::class, 'update'])
        ->name('peminjaman.update');

    Route::delete('/peminjaman/delete/{id}', [PeminjamanController::class, 'delete'])
        ->name('peminjaman.delete');

    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian.index');

    Route::post('/pengembalian/{id}', [PengembalianController::class, 'kembalikan'])
        ->name('pengembalian.kembalikan');

});