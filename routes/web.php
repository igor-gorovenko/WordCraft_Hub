<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilterController;

Route::get('/', [WordController::class, 'index'])->name('index');
Route::get('/{id}', [WordController::class, 'show'])->name('show')->where('id', '[0-9]+');

Route::get('/filter', [WordController::class, 'filter']);
Route::get('/export', [WordController::class, 'export'])->name('export');
