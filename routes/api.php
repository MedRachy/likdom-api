<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\OffersController;
use App\Http\Controllers\api\SubscriptionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// offers 
Route::get('/offers/pro', [OffersController::class, 'pro_offers']);
Route::get('/offers/part', [OffersController::class, 'part_offers']);

// get available hours
Route::get('/get/available/hours/{date}', [SubscriptionsController::class, 'get_available_hours']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UsersController::class, 'show']);
    Route::post('/user/update', [UsersController::class, 'update']);
    Route::post('/user/update-adresse', [UsersController::class, 'update']);
    Route::post('/user/update-password', [UsersController::class, 'update_password']);
    // subscriptions 
    Route::post('/subscription/create/once', [SubscriptionsController::class, 'store_once']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
