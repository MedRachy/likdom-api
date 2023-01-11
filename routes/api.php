<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ContractsController;
use App\Http\Controllers\api\OffersController;
use App\Http\Controllers\api\SubscriptionsController;
use App\Http\Controllers\api\VerifyMobileController;
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

// get offers 
Route::get('/offers/pro', [OffersController::class, 'pro_offers']);
Route::get('/offers/part', [OffersController::class, 'part_offers']);

// get total price 
Route::get('/get_total_price/{nbr_hours}/{nbr_employees}', [SubscriptionsController::class, 'get_total_price']);
Route::get('/get_pro_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}', [SubscriptionsController::class, 'get_pro_total_price']);
Route::get('/get_part_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}', [SubscriptionsController::class, 'get_part_total_price']);

Route::middleware('auth:sanctum')->group(function () {
    // user account
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UsersController::class, 'show']);
    Route::post('/user/update', [UsersController::class, 'update']);
    Route::post('/user/update-password', [UsersController::class, 'update_password']);
    Route::post('/user/delete', [UsersController::class, 'destroy']);
    // subscriptions 
    Route::get('/get/subscriptions', [SubscriptionsController::class, 'get_all_sub']);
    Route::get('/get/subscriptions/concluded', [SubscriptionsController::class, 'get_all_concluded_sub']);
    Route::post('/create/subscription', [SubscriptionsController::class, 'store_sub']);
    Route::get('/recap/{id}', [SubscriptionsController::class, 'recap']);
    // reservations
    Route::post('/create/reservation', [SubscriptionsController::class, 'store_reserv']);
    Route::put('/confirm/{id}', [SubscriptionsController::class, 'to_confirm']);
    // contracts
    Route::post('/create/contract', [ContractsController::class, 'store']);
    // verify user phone number
    Route::get('/send_code/{phone}', [VerifyMobileController::class, 'send_code']);
    Route::post('/verify_phone', [VerifyMobileController::class, 'verify_phone']);
});
