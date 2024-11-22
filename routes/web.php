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
    route::post('/admin/tambahpasien', [AdminController::class, 'tambahpasien'])->name('admin.tambahpasien');
    Route::get('/admin/search-antrian', [AdminController::class, 'searchAntrian'])->name('admin.search.antrian');
    Route::get('/admin/search-antrian2', [AdminController::class, 'searchAntrian2'])->name('admin.search.antrian2');
    Route::get('/admin/rekam-medis', [AdminController::class, 'rekammedis'])->name('admin.rekammedis');
    Route::delete('/admin/daftarantrian/{id}', [AdminController::class, 'deletePatient'])->name('admin.delete.antrian');
    Route::put('/admin/daftarantrian/{id}/edit', [AdminController::class, 'editPatient'])->name('admin.edit.antrian');
    Route::put('/admin/mark-as-completed/{id}', [AdminController::class, 'markAsCompleted'])->name('admin.markAsCompleted');
    Route::put('/admin/mark-as-in-progress/{id}', [AdminController::class, 'markAsInProgress'])->name('admin.markAsInProgress');
    Route::post('/admin/patient/{id}/update-status', [AdminController::class, 'updateStatus'])->name('admin.patient.updateStatus');
    Route::get('/admin/search/suggestions', [AdminController::class, 'searchSuggestions'])->name('admin.search.suggestions');
    Route::get('/admin/patients/today', [AdminController::class, 'patientsToday'])->name('admin.patients.today');
    Route::get('/admin/patients/weekly', [AdminController::class, 'patientsWeekly'])->name('admin.patients.weekly');
    Route::get('/admin/detail-pasien/{id}', [AdminController::class, 'detailPasien'])->name('admin.detail.pasien');


});
route::middleware(['auth', Dokter::class])->group(function(){
    route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    Route::get('/dokter/patients/today', [DokterController::class, 'patientsToday'])->name('dokter.patients.today');
    Route::get('/dokter/patients/weekly', [DokterController::class, 'patientsWeekly'])->name('dokter.patients.weekly');
    route::get('/dokter/daftarantrian', [DokterController::class, 'daftarantrian'])->name('dokter.daftarantrian');
    Route::get('/dokter/search-antrian', [DokterController::class, 'searchAntrian'])->name('dokter.search.antrian');
    Route::get('/dokter/rekam-medis', [DokterController::class, 'rekammedis'])->name('dokter.rekammedis');
    Route::delete('/dokter/delete/{id}', [DokterController::class, 'deletePatient'])->name('dokter.delete');

    Route::get('/dokter/detailpasien/{id}', [DokterController::class, 'lihatdetail'])->name('dokter.lihatdetail');
    Route::put('/dokter/mark-as-completed/{id}', [DokterController::class, 'markAsCompleted'])->name('dokter.markAsCompleted');
    Route::put('/dokter/mark-as-in-progress/{id}', [DokterController::class, 'markAsInProgress'])->name('dokter.markAsInProgress');
    Route::post('/dokter/patient/{id}/update-status', [DokterController::class, 'updateStatus'])->name('dokter.patient.updateStatus');
    Route::put('/dokter/periksa/{id}', [DokterController::class, 'markAsInProgress'])->name('dokter.markAsInProgress');
    Route::post('/dokter/save-examination', [DokterController::class, 'saveExamination'])->name('dokter.saveExamination');


});
