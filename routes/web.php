<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;


Route::get('/', [WordController::class, 'index'])->name('site.index');
Route::get('/filter', [WordController::class, 'filter'])->name('filter');

Route::get('/export', [WordController::class, 'export'])->name('export');
