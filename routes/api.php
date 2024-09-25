<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DietFavouriteController;
use App\Http\Controllers\DietsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\WaterLogController;
use App\Http\Controllers\WorkoutFavouriteController;
use App\Http\Controllers\WorkoutsController;
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
Route::post('/signup', [ClientController::class, 'signup']);

Route::post('/login', [ClientController::class, 'login']);

Route::middleware('auth:sanctum')->put('/completeProfile', [ClientController::class, 'completeProfile']);
Route::middleware('auth:sanctum')->delete('/deleteAccount', [ClientController::class, 'deleteProfile']);
Route::middleware('auth:sanctum')->put('/editProfile', [ClientController::class, 'editProfile']);

// Diet
Route::get('/diet/cats/all', [DietsController::class, 'dietCats']);
Route::get('/notifications/all', [NotificationsController::class, 'index']);

Route::middleware('api.optional.auth')->group(function () {
    Route::get('/diet/dietMeals/all', [DietsController::class, 'dietMeals']);
    Route::get('/diet/snacksMeals/all', [DietsController::class, 'snacksDietMeals']);
    Route::get('/diet/breakfastMeals/all', [DietsController::class, 'breakfastDietMeals']);
    Route::get('/diet/launchMeals/all', [DietsController::class, 'launchDietMeals']);
    Route::get('/diet/dinnerMeals/all', [DietsController::class, 'dinnerDietMeals']);
    Route::get('/diet/summary', [DietsController::class, 'summary']);
    Route::get('/workouts/dietCategoryMeals/{id}', [DietsController::class, 'dietCategoryMeals']);
});

//Workouts

Route::get('/workouts/bodyParts/all', [WorkoutsController::class, 'bodyParts']);
Route::get('/workouts/equipments/all', [WorkoutsController::class, 'equipments']);
Route::middleware('api.optional.auth')->group(function () {
    Route::get('/workouts/summary', [WorkoutsController::class, 'summary']);
    Route::get('/workouts/exercises/all', [WorkoutsController::class, 'exercises']);
    Route::get('/workouts/bodyPartExercises/{id}', [WorkoutsController::class, 'bodyPartExercises']);
    Route::get('/workouts/equipmentExercises/{id}', [WorkoutsController::class, 'equipmentExercises']);
});


//Water Logger
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/waterLog/summary', [WaterLogController::class, 'summary']);
    Route::get('/waterLog/all', [WaterLogController::class, 'all']);
    Route::delete('/waterLog/delete', [WaterLogController::class, 'delete']);
    Route::put('/waterLog/add', [WaterLogController::class, 'add']);
});

// Diet Favs
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favourites/diet/add', [DietFavouriteController::class, 'addToFavourite']);
    Route::delete('/favourites/diet/remove', [DietFavouriteController::class, 'removeFromFavourite']);
    Route::get('/favourites/diet/all', [DietFavouriteController::class, 'getFavourites']);
});

// Exercises Favs
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favourites/exercise/add', [WorkoutFavouriteController::class, 'addToFavourite']);
    Route::delete('/favourites/exercise/remove', [WorkoutFavouriteController::class, 'removeFromFavourite']);
    Route::get('/favourites/exercise/all', [WorkoutFavouriteController::class, 'getFavourites']);
});

