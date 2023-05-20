<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::post('login', [UserController::class, 'authenticate']);
Route::post('register', [UserController::class, 'register']);