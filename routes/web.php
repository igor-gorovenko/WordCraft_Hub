<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WordController::class, 'index'])->name('index');
Route::get('/{id}', [WordController::class, 'show'])->name('show')->where('id', '[0-9]+');
