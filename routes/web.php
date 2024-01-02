<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WordController::class, 'index'])->name('site.index');
Route::get('/{id}', [WordController::class, 'show'])->name('site.show')->where('id', '[0-9]+');

Route::get('/filter', [WordController::class, 'filter']);
Route::get('/export', [WordController::class, 'export'])->name('export');
