<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lightit\Backoffice\Cities\App\Controllers\DeleteCityController;
use Lightit\Backoffice\Cities\App\Controllers\GetCityController;
use Lightit\Backoffice\Cities\App\Controllers\ListCityController;
use Lightit\Backoffice\Cities\App\Controllers\StoreCityController;
use Lightit\Backoffice\Cities\App\Controllers\UpdateCityController;
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

