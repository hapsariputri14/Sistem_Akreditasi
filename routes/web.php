<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PSertifikasiController;

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

// routes/web.php
Route::get('/', function () {
    return view('home');
});


Route::prefix('manage-level')->group(function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');

    // CRUD routes
    Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
    Route::post('/store_ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax'])->name('level.confirm_ajax');
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
    Route::get('/{id}/detail_ajax', [LevelController::class, 'detail_ajax'])->name('level.detail_ajax');

    // Import and Export routes
    Route::get('/import', [LevelController::class, 'import'])->name('level.import');
    Route::post('/import_ajax', [LevelController::class, 'import_ajax'])->name('level.import_ajax');
    Route::get('/export_excel', [LevelController::class, 'export_excel'])->name('level.export_excel');
    Route::get('/export_pdf', [LevelController::class, 'export_pdf'])->name('level.export_pdf');
});

Route::prefix('p_sertifikasi')->group(function () {
    Route::get('/', [PSertifikasiController::class, 'index'])->name('p_sertifikasi.index');

    // CRUD routes
    Route::get('/create_ajax', [PSertifikasiController::class, 'create'])->name('p_sertifikasi.create_ajax');
    Route::post('/store_ajax', [PSertifikasiController::class, 'store_ajax'])->name('p_sertifikasi.store_ajax');
    Route::get('/{id}/edit_ajax', [PSertifikasiController::class, 'edit_ajax'])->name('p_sertifikasi.edit_ajax');
    Route::put('/{id}/update_ajax', [PSertifikasiController::class, 'update_ajax'])->name('p_sertifikasi.update_ajax');
    Route::get('/{id}/delete_ajax', [PSertifikasiController::class, 'confirm_ajax'])->name('p_sertifikasi.confirm_ajax');
    Route::delete('/{id}/delete_ajax', [PSertifikasiController::class, 'delete_ajax'])->name('p_sertifikasi.delete_ajax');
    Route::get('/{id}/detail_ajax', [PSertifikasiController::class, 'detail_ajax'])->name('p_sertifikasi.detail_ajax');
    Route::post('/validasi_ajax', [PSertifikasiController::class, 'validasi_ajax'])->name('p_sertifikasi.validasi_ajax');


    // Import and Export routes
    Route::get('/import', [PSertifikasiController::class, 'import'])->name('p_sertifikasi.import');
    Route::post('/import_ajax', [PSertifikasiController::class, 'import_ajax'])->name('p_sertifikasi.import_ajax');
    Route::get('/export_excel', [PSertifikasiController::class, 'export_excel'])->name('p_sertifikasi.export_excel');
    Route::get('/export_pdf', [PSertifikasiController::class, 'export_pdf'])->name('p_sertifikasi.export_pdf');
});
