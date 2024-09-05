<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

use App\Http\Middleware\PasetoAuth;


Route::post('/login', [AuthController::class, 'login']);


Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class)->middleware(PasetoAuth::class);



