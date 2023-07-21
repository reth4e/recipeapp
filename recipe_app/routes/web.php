<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'],function() {
    Route::get('/recipes', [RecipeController::class, 'recipes']);
    Route::get('/favorites', [RecipeController::class, 'favorites']);
    Route::get('/favorite/{recipe_id}', [RecipeController::class, 'favorite']);
    Route::get('/guide', [RecipeController::class, 'guide']);

    Route::get('/contact', [UserController::class, 'contact']);
    Route::get('/list_messages', [UserController::class, 'messages']);
    Route::post('/message', [UserController::class, 'sendMessage']);
    Route::get('/message/{message_id}', [UserController::class, 'message']);
    Route::post('/reply/{message_id}', [UserController::class, 'sendReply']);
    Route::get('/notifications', [UserController::class, 'notifications']);
    Route::get('/notification/{notification_id}', [UserController::class, 'read']);
});
require __DIR__.'/auth.php';
