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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'blog_categories'], function (){
    Route::get('/',[App\Http\Controllers\BlogCategoryController::class, 'index']);
    Route::post('/',[App\Http\Controllers\BlogCategoryController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\BlogCategoryController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\BlogCategoryController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\BlogCategoryController::class, 'delete']);
});

Route::group(['prefix' => 'comments'], function (){
    Route::get('/',[App\Http\Controllers\CommentsController::class, 'index']);
    Route::post('/',[App\Http\Controllers\CommentsController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\CommentsController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\CommentsController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\CommentsController::class, 'delete']);
});

Route::group(['prefix' => 'blogs'], function (){
    Route::get('/',[App\Http\Controllers\BlogsController::class, 'index']);
    Route::post('/',[App\Http\Controllers\BlogsController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\BlogsController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\BlogsController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\BlogsController::class, 'delete']);
});

Route::group(['prefix' => 'Categories'], function (){
    Route::get('/',[App\Http\Controllers\CategoriesController::class, 'index']);
    Route::post('/',[App\Http\Controllers\CategoriesController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\CategoriesController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\CategoriesController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\CategoriesController::class, 'delete']);
});

Route::group(['prefix' => 'Product'], function (){
    Route::get('/',[App\Http\Controllers\ProductController::class, 'index']);
    Route::post('/',[App\Http\Controllers\ProductController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\ProductController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\ProductController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\ProductController::class, 'delete']);
});

Route::group(['prefix' => 'ProductPromotion'], function (){
    Route::get('/',[App\Http\Controllers\ProductPromotionController::class, 'index']);
    Route::post('/',[App\Http\Controllers\ProductPromotionController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\ProductPromotionController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\ProductPromotionController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\ProductPromotionController::class, 'delete']);
});

Route::group(['prefix' => 'Promotion'], function (){
    Route::get('/',[App\Http\Controllers\PromotionController::class, 'index']);
    Route::post('/',[App\Http\Controllers\PromotionController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\PromotionController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\PromotionController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\PromotionController::class, 'delete']);
});

Route::post('/',[App\Http\Controllers\ContactController::class, 'store']);