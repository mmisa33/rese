<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');

Route::view('/thanks', 'auth.thanks')->name('register.thanks');