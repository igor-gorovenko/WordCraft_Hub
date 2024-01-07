<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WordController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/filter', [HomeController::class, 'filter'])->name('filter');

Route::get('/export', [HomeController::class, 'export'])->name('export');

Route::prefix('/word')->name('word.')->group(function () {
    Route::get('/create', [WordController::class, 'create'])->name('create');
    Route::post('/store', [WordController::class, 'store'])->name('store');
});
