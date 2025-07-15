<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/admin/login' , [AuthController::class, 'authenticate']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    // Route::get('/admin/categories', [CategoryController::class, 'index']);
    // Route::post('/admin/categories', [CategoryController::class, 'store']);
    // Route::get('/admin/categories/{id}', [CategoryController::class, 'show']);
    // Route::put('/admin/categories/{id}', [CategoryController::class, 'update']);
    // Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy']);


    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
});