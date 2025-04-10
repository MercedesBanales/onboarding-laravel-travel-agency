<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lightit\Backoffice\Airlines\App\Controllers\DeleteAirlineController;
use Lightit\Backoffice\Airlines\App\Controllers\GetAirlineController;
use Lightit\Backoffice\Airlines\App\Controllers\ListAirlineController;
use Lightit\Backoffice\Airlines\App\Controllers\StoreAirlineController;
use Lightit\Backoffice\Airlines\App\Controllers\UpdateAirlineController;
use Lightit\Backoffice\Cities\App\Controllers\DeleteCityController;
use Lightit\Backoffice\Cities\App\Controllers\GetCityController;
use Lightit\Backoffice\Cities\App\Controllers\ListCityController;
use Lightit\Backoffice\Cities\App\Controllers\StoreCityController;
use Lightit\Backoffice\Cities\App\Controllers\UpdateCityController;
use Lightit\Backoffice\Flights\App\Controllers\DeleteFlightController;
use Lightit\Backoffice\Flights\App\Controllers\GetFlightController;
use Lightit\Backoffice\Flights\App\Controllers\ListFlightController;
use Lightit\Backoffice\Flights\App\Controllers\StoreFlightController;
use Lightit\Backoffice\Flights\App\Controllers\UpdateFlightController;
use Lightit\Backoffice\Users\App\Controllers\{
    DeleteUserController, GetUserController, ListUserController, StoreUserController
};

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

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::prefix('users')
    ->middleware([])
    ->group(static function () {
        Route::get('/', ListUserController::class);
        Route::get('/{user}', GetUserController::class)->withTrashed();
        Route::post('/', StoreUserController::class);
        Route::delete('/{user}', DeleteUserController::class);
    });

/*
|--------------------------------------------------------------------------
| Cities Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cities')
->group(static function () {
    Route::get('/', ListCityController::class);
    Route::get('/{city}', GetCityController::class);
    Route::post('/', StoreCityController::class);
    Route::patch('/{city}', UpdateCityController::class);
    Route::delete('/{city}', DeleteCityController::class);
});

/*
|--------------------------------------------------------------------------
| Airlines Routes
|--------------------------------------------------------------------------
*/
Route::prefix('airlines')
->group(static function () {
    Route::get('/', ListAirlineController::class);
    Route::get('/{airline}', GetAirlineController::class);
    Route::post('/', StoreAirlineController::class);
    Route::patch('/{airline}', UpdateAirlineController::class);
    Route::delete('/{airline}', DeleteAirlineController::class);
});

/*
|--------------------------------------------------------------------------
| Flights Routes
|--------------------------------------------------------------------------
*/
Route::prefix('flights')
->group(static function () {
    Route::get('/', ListFlightController::class);
    Route::get('/{flight}', GetFlightController::class);
    Route::post('/', StoreFlightController::class);
    Route::patch('/{flight}', UpdateFlightController::class);
    Route::delete('/{flight}', DeleteFlightController::class);
});

