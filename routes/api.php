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
Route::get('/diet/cats/all', [\App\Http\Controllers\DietsController::class, 'dietCats']);
Route::get('/diet/dietMeals/all', [\App\Http\Controllers\DietsController::class, 'dietMeals']);
Route::get('/diet/snacksMeals/all', [\App\Http\Controllers\DietsController::class, 'snacksDietMeals']);
Route::get('/diet/breakfastMeals/all', [\App\Http\Controllers\DietsController::class, 'breakfastDietMeals']);
Route::get('/diet/launchMeals/all', [\App\Http\Controllers\DietsController::class, 'launchDietMeals']);
Route::get('/diet/dinnerMeals/all', [\App\Http\Controllers\DietsController::class, 'dinnerDietMeals']);
Route::get('/diet/summary', [\App\Http\Controllers\DietsController::class, 'summary']);

//Workouts
Route::get('/workouts/summary', [\App\Http\Controllers\WorkoutsController::class, 'summary']);
Route::get('/workouts/bodyParts/all', [\App\Http\Controllers\WorkoutsController::class, 'bodyParts']);
Route::get('/workouts/equipments/all', [\App\Http\Controllers\WorkoutsController::class, 'equipments']);
Route::get('/workouts/exercises/all', [\App\Http\Controllers\WorkoutsController::class, 'exercises']);
Route::get('/workouts/bodyPartExercises/{id}', [\App\Http\Controllers\WorkoutsController::class, 'bodyPartExercises']);
Route::get('/workouts/equipmentExercises/{id}', [\App\Http\Controllers\WorkoutsController::class, 'equipmentExercises']);


