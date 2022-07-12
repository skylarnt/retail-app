<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'api'], function () {

    Route::prefix('auth')->group(function() {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('api');
        Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('api');
        Route::get('logout', [AuthController::class, 'logout'])->withoutMiddleware('api');
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', function($q) {
            return auth()->user();
        });

    });

    Route::prefix('inventory')->group(function() {
        Route::get('/', [InventoryController::class, 'index']);
        Route::get('/{inventory}', [InventoryController::class, 'show']);
        Route::post('/', [InventoryController::class, 'store']);
        Route::put('update/{id}', [InventoryController::class, 'update']);
        Route::delete('delete/{id}', [InventoryController::class, 'destroy']);
        

    });

    Route::prefix('user')->group(function() {
        Route::get('/view_inventories', [UserController::class, 'index']);
        
        Route::prefix('cart')->group(function() {
            Route::post('/view', [CartController::class, 'index']);
            Route::post('/add', [CartController::class, 'store']);
        });
        

    });

   

});
