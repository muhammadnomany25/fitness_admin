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

Route::post('/technician/login', [\App\Http\Controllers\TechnicianController::class, 'login']);

Route::middleware('auth:sanctum')->get('/orders/techOrders', [\App\Http\Controllers\OrderController::class, 'techOrders']);
Route::middleware('auth:sanctum')->get('/fixItems/all', [\App\Http\Controllers\FixItemsController::class, 'fixItems']);
Route::middleware('auth:sanctum')->post('/technician/completeOrder', [\App\Http\Controllers\TechnicianController::class, 'completeOrder']);

