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
    Route::get('/',[App\Http\Controllers\CommentController::class, 'index']);
    Route::post('/',[App\Http\Controllers\CommentController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\CommentController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\CommentController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\CommentController::class, 'destroy']);
});

Route::group(['prefix' => 'blogs'], function (){
    Route::get('/',[App\Http\Controllers\BlogController::class, 'index']);
    Route::post('/',[App\Http\Controllers\BlogController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\BlogController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\BlogController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\BlogController::class, 'destroy']);
});
