<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products/{id}', [ProductController::class], 'show');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

# Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::controller(ProductController::class)->group(function(){
        Route::post('/products', 'store');
        Route::put('/products/{id}', 'update');
        Route::delete('/products/{id}', 'destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

