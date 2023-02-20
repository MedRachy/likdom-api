<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ContractsController;
use App\Http\Controllers\api\OffersController;
use App\Http\Controllers\api\SubscriptionsController;
use App\Http\Controllers\api\VerifyMobileController;
use App\Http\Controllers\UsersController;
use Carbon\Carbon;
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
// auth & register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// verify user phone number
Route::get('/send_code/{phone}', [VerifyMobileController::class, 'send_code']);
Route::post('/verify_phone', [VerifyMobileController::class, 'verify_phone']);

// get offers 
Route::get('/offers/pro', [OffersController::class, 'pro_offers']);
Route::get('/offers/part', [OffersController::class, 'part_offers']);

// get total price 
Route::get('/get_total_price/{nbr_hours}/{nbr_employees}', [SubscriptionsController::class, 'get_total_price']);
Route::get('/get_pro_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}', [SubscriptionsController::class, 'get_pro_total_price']);
Route::get('/get_part_total_price/{nbr_hours}/{nbr_employees}/{nbr_passages}', [SubscriptionsController::class, 'get_part_total_price']);

// reset password
Route::get('/send_reset_code/{phone}', [UsersController::class, 'send_reset_code']);
Route::post('/verify_reset_password', [UsersController::class, 'verify_reset_password']);

// get date and time
Route::get('/get_date_time', function () {

    $date = Carbon::today()->tz("Africa/Casablanca")->format('Y-m-d');
    $time = Carbon::now()->tz("Africa/Casablanca")->format('H:i');

    return  response()->json(['date' => $date, 'time' => $time], 200);
});

Route::middleware('auth:sanctum')->group(function () {
    // user account
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UsersController::class, 'show']);
    Route::put('/user/update', [UsersController::class, 'update']);
    Route::post('/user/update-password', [UsersController::class, 'update_password']);
    Route::post('/user/update-phone', [VerifyMobileController::class, 'update_and_verify_phone']);
    Route::post('/user/delete', [UsersController::class, 'destroy']);
    Route::post('/user/password-check', [UsersController::class, 'password_check']);
    // subscriptions 
    Route::get('/get/subscriptions', [SubscriptionsController::class, 'get_all_sub']);
    Route::get('/get/subscriptions/concluded', [SubscriptionsController::class, 'get_all_concluded_sub']);
    Route::post('/create/subscription-with-contract', [SubscriptionsController::class, 'store_with_contract']);
    Route::post('/create/subscription', [SubscriptionsController::class, 'store_sub']);
    Route::get('/recap/{id}', [SubscriptionsController::class, 'recap']);
    // reservations
    Route::post('/create/reservation', [SubscriptionsController::class, 'store_reserv']);
    Route::put('/confirm/{id}', [SubscriptionsController::class, 'to_confirm']);
    // contracts
    Route::post('/create/contract', [ContractsController::class, 'store']);
});


Route::post('/send_email', [UsersController::class, 'send_email']);
