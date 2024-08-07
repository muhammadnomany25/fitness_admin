<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Client Auth
Route::post('/signup', [\App\Http\Controllers\ClientController::class, 'signup']);

Route::post('/login', [\App\Http\Controllers\ClientController::class, 'login']);

Route::middleware('auth:sanctum')->put('/completeProfile', [\App\Http\Controllers\ClientController::class, 'completeProfile']);

// Diet
Route::middleware('auth:sanctum')->get('/dietCats/all', [\App\Http\Controllers\DietsController::class, 'dietCats']);
Route::middleware('auth:sanctum')->get('/dietMeals/all', [\App\Http\Controllers\DietsController::class, 'dietMeals']);
Route::middleware('auth:sanctum')->get('/snacksDietMeals/all', [\App\Http\Controllers\DietsController::class, 'snacksDietMeals']);

