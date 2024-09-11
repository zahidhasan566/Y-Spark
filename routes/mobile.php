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
Route::post('mobile-login', [\App\Http\Controllers\Mobile\Auth\MobileLoginController::class, 'index']);
Route::post('otp-verification', [\App\Http\Controllers\Mobile\Auth\MobileLoginController::class, 'otpVerification']);


Route::group(['middleware' => ['jwt']], function () {

    //LA USERS
    Route::group(['prefix' => 'farmer'],function () {

        //get dashboardData
        Route::post('get-dashboard-info',[\App\Http\Controllers\Mobile\La\Dashborad\DashboardController::class,'index']);

        //FARM AND COW
        Route::post('get-farmList-info',[App\Http\Controllers\Mobile\La\Farm\FarmController::class,'getFarmInfo']);
        Route::post('get-userBasedFarmList-info',[App\Http\Controllers\Mobile\La\Farm\FarmController::class,'getUserBasedFarmInfo']);
        Route::post('store-farm-data',[App\Http\Controllers\Mobile\La\Farm\FarmController::class,'storeFarmData']);
        Route::post('store-cow-data',[App\Http\Controllers\Mobile\La\Farm\CowController::class,'storeCowData']);

        //BREEDING
        Route::post('get-bull-data',[App\Http\Controllers\Mobile\La\Breeding\BreedingController::class,'getBullData']);
        Route::post('get-bullType-data',[App\Http\Controllers\Mobile\La\Breeding\BreedingController::class,'getBullTypeData']);
        Route::post('store-breeding-data',[App\Http\Controllers\Mobile\La\Breeding\BreedingController::class,'storeBreedingData']);
        Route::post('get-breeding-data',[App\Http\Controllers\Mobile\La\Breeding\BreedingController::class,'getBreedingData']);

        //RE BREEDING
        Route::post('get-re-breeding-data',[App\Http\Controllers\Mobile\La\Breeding\ReBreedingController::class,'getReBreedingData']);
        Route::post('store-re-breeding-data',[App\Http\Controllers\Mobile\La\Breeding\ReBreedingController::class,'storeReBreedingData']);

        //PREGNANCY INFORMATION
        Route::post('get-pregnancy-supporting-data',[\App\Http\Controllers\Mobile\La\Pregnacy\PregnancyContrller::class,'getPregnancySupportingData']);
        Route::post('store-pregnancy-data',[\App\Http\Controllers\Mobile\La\Pregnacy\PregnancyContrller::class,'storePregnancyData']);
        Route::post('get-all-pregnancy-data',[\App\Http\Controllers\Mobile\La\Pregnacy\PregnancyContrller::class,'getAllPregnancyData']);

        //CULF INFORMATION
        Route::post('get-culf-supporting-data',[\App\Http\Controllers\Mobile\La\Culf\CulfController::class,'getCulfSupportingData']);
        Route::post('store-culf-data',[\App\Http\Controllers\Mobile\La\Culf\CulfController::class,'storeCulfData']);
        Route::post('get-all-culf-data',[\App\Http\Controllers\Mobile\La\Culf\CulfController::class,'getAllCulfData']);


    });


});
