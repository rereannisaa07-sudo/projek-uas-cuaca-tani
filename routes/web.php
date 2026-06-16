<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\CuacaController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('lahan.index');
    })->name('dashboard');

    Route::resource('lahan', LahanController::class);

    Route::get('/cuaca', [CuacaController::class, 'index'])->name('cuaca.index');
    Route::post('/cuaca/cek', [CuacaController::class, 'cekCuaca'])->name('cuaca.cek');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/database', [AdminController::class, 'database'])->name('admin.database');
});

require __DIR__.'/auth.php';