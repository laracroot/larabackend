<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
