<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// route Category




Route::post('/auth/login', [UserController::class, 'login'])->name('login');

Route::middleware([AuthenticateUser::class])->group(function () {
    Route::delete('/logout', [UserController::class, 'logout']);

    Route::post('/category', [CategoryController::class, 'create']);
    Route::get('/category', [CategoryController::class, 'get']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

    Route::post('/product', [ProductController::class, 'create']);
    Route::get('/product', [ProductController::class, 'get']);
    Route::get('/product/{id}', [ProductController::class, 'getId']);
    Route::get('/product/category/{id}', [ProductController::class, 'getInCategory']);
    Route::put('/product/{id}', [ProductController::class, 'update']);

    Route::post('/carts', [CartController::class, 'create']);
});
