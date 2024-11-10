<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Dokter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::redirect('/', 'login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

route::middleware(['auth', Admin::class])->group(function(){
    route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    route::get('/admin/daftarantrian', [AdminController::class, 'daftarantrian'])->name('admin.daftarantrian');
    route::post('/admin/tambahantrian', [AdminController::class, 'tambahantrian'])->name('admin.tambahantrian');
    Route::get('/admin/search-antrian', [AdminController::class, 'searchAntrian'])->name('admin.search.antrian');
    Route::get('/admin/rekam-medis', [AdminController::class, 'rekammedis'])->name('admin.rekammedis');
});
route::middleware(['auth', Dokter::class])->group(function(){
    route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    route::get('/dokter/daftarantrian', [DokterController::class, 'daftarantrian'])->name('dokter.daftarantrian');    
    Route::get('/dokter/search-antrian', [DokterController::class, 'searchAntrian'])->name('dokter.search.antrian');
    Route::get('/dokter/rekam-medis', [DokterController::class, 'rekammedis'])->name('dokter.rekammedis');
    Route::get('/dokter/detailpasien/{id}', [DokterController::class, 'lihatdetail'])->name('dokter.lihatdetail');
});