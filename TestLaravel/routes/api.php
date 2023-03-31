<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

//post Controller
Route::prefix('post')->group(function ()
        {
            Route::get('list',[PostController::class,'index']);
            Route::post('store', [PostController::class ,'store']);
            Route::get('show/{id}' ,[PostController::class ,'view']);
        });


//Comment Controller
Route::prefix('comment')->group(function ()
        {
            Route::get('list', [ CommentController::class,'index']);
            Route::post('store/{post_id}' , [ CommentController::class,'store']);
           // Route::get('show/{id}' ,[ CommentController::class ,'view']);
        });