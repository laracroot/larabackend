<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::any('/', function () {
    return response()->json(['message' => 'Welcome to the API'], 200);
});
