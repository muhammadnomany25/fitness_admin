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
Route::get('/dietCats/all', [\App\Http\Controllers\DietsController::class, 'dietCats']);
Route::get('/dietMeals/all', [\App\Http\Controllers\DietsController::class, 'dietMeals']);
Route::get('/snacksDietMeals/all', [\App\Http\Controllers\DietsController::class, 'snacksDietMeals']);
Route::get('/breakfastDietMeals/all', [\App\Http\Controllers\DietsController::class, 'breakfastDietMeals']);
Route::get('/launchDietMeals/all', [\App\Http\Controllers\DietsController::class, 'launchDietMeals']);
Route::get('/dinnerDietMeals/all', [\App\Http\Controllers\DietsController::class, 'dinnerDietMeals']);
Route::get('/summary', [\App\Http\Controllers\DietsController::class, 'summary']);

