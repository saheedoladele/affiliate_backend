<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\AdminController;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth/login', [UserController::class, 'login']);
    Route::post('/auth/logout', [UserController::class, 'logout']);
    Route::post('/auth/register', [UserController::class, 'store']);

});

Route::group(['prefix' => 'v1'], function (){
    // create, update/{id}, delete/{id}, read, read-single
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/stat', [UserController::class, 'stat']);

    Route::get('/buyers', [BuyerController::class, 'index']);
    Route::post('/buyers', [BuyerController::class, 'store']);
    Route::get('/buyers/{id}', [BuyerController::class, 'show']);
    Route::put('/buyers/{id}', [BuyerController::class, 'update']);
    Route::delete('/buyers/{id}', [BuyerController::class, 'destroy']);

    
    Route::apiResource('banks', BankController::class);
    Route::get('/bank/user', [BankController::class, 'userBank']);
    Route::apiResource('properties', PropertyController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('admins', AdminController::class);
    Route::post('/admin/login', [AdminController::class, 'login']);
    Route::post('/admin/logout', [AdminController::class, 'logout']);
});