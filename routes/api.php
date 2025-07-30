<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TempImageController;
use App\Http\Controllers\front\ProductController as FrontProductController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/admin/login' , [AuthController::class, 'authenticate']);
Route::get('/latest-products', [FrontProductController::class, 'latestProducts']);
Route::get('/featured-products', [FrontProductController::class, 'getfeaturedProducts']);
Route::get('/get-categories', [FrontProductController::class, 'getCategories']);
Route::get('/get-brands', [FrontProductController::class, 'getBrands']);
Route::get('/get-products', [FrontProductController::class, 'getProducts']);
Route::get('/get-product/{id}', [FrontProductController::class, 'getProduct']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    // Route::get('/admin/categories', [CategoryController::class, 'index']);
    // Route::post('/admin/categories', [CategoryController::class, 'store']);
    // Route::get('/admin/categories/{id}', [CategoryController::class, 'show']);
    // Route::put('/admin/categories/{id}', [CategoryController::class, 'update']);
    // Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy']);


    Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('sizes', SizeController::class);
        Route::resource('products', ProductController::class);
        Route::post('temp-images', [TempImageController::class, 'store']);
});