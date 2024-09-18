<?php

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

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('login-otp-verification', [\App\Http\Controllers\Auth\AuthController::class, 'otpVerification']);


Route::group(['middleware' => ['jwt','throttle:10000,1']], function () {
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\Auth\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\Auth\AuthController::class, 'me']);
    Route::get('app-supporting-data', [\App\Http\Controllers\Common\HelperController::class, 'appSupportingData']);
});


Route::group(['middleware' =>  ['jwt','throttle:10000,1']], function () {
    //Service History
    Route::group(['prefix' => 'service-history'],function () {
        Route::get('list', [\App\Http\Controllers\ServiceHistory\ServiceHistoryController::class, 'getServiceHistory']);
        Route::get('schedule', [\App\Http\Controllers\ServiceHistory\ServiceHistoryController::class, 'getServiceSchedule']);
    });

    //Warranty
    Route::group(['prefix' => 'warranty'],function () {
        Route::get('supporting-data', [\App\Http\Controllers\Warranty\WarrantyController::class, 'getSupportingData']);
    });

    //Online Booking
    Route::group(['prefix' => 'online-booking'],function () {
        Route::get('supporting-data', [\App\Http\Controllers\OnlineBooking\OnlineBookingController::class, 'getSupportingData']);
        Route::post('location-wise-time-slot', [\App\Http\Controllers\OnlineBooking\OnlineBookingController::class, 'getBayinfoByLocation']);
        Route::post('add', [\App\Http\Controllers\OnlineBooking\OnlineBookingController::class, 'onlineBooking']);
    });

    //Common Supporting Data
    Route::group(['prefix' => 'common-supporting'],function () {
        Route::get('list', [\App\Http\Controllers\Common\CommonSupportingController::class, 'getSupportingData']);;
    });
    Route::group(['prefix' => 'events'],function () {
        Route::get('list', [\App\Http\Controllers\Event\EventController::class, 'getSupportingData']);;
    });

//    // ADMIN USERS
//    Route::group(['prefix' => 'user'],function () {
//        Route::post('list', [\App\Http\Controllers\Admin\Users\AdminUserController::class, 'index']);
//        //User Modal Data
//        Route::get('modal',[\App\Http\Controllers\Admin\Users\AdminUserController::class,'userModalData']);
//        Route::post('add', [\App\Http\Controllers\Admin\Users\AdminUserController::class, 'store']);
//        Route::get('get-user-info/{UserId}',[\App\Http\Controllers\Admin\Users\AdminUserController::class,'getUserInfo']);
//        Route::post('update', [\App\Http\Controllers\Admin\Users\AdminUserController::class, 'update']);
//        Route::post('password-change',[\App\Http\Controllers\Common\HelperController::class,'passwordChange']);
//    });


});

