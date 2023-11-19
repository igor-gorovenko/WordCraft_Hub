<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WordController::class, 'index']);
