<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\CuacaController;

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

require __DIR__.'/auth.php';
