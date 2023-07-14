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

Route::get('/recipes', [RecipeController::class, 'recipes']);
Route::get('/favorites', [RecipeController::class, 'favorites']);
Route::get('/favorite', [RecipeController::class, 'favorite']);
Route::get('/detach_favorite', [RecipeController::class, 'detachFavorite']);
Route::get('/guide', [RecipeController::class, 'guide']);


Route::get('/contact', [UserController::class, 'contact']);
Route::get('/messages', [UserController::class, 'messages']);
Route::get('/message', [UserController::class, 'message']);
Route::post('/message', [UserController::class, 'sendMessage']);
Route::post('/response', [UserController::class, 'sendResponse']);
Route::get('/notifications', [UserController::class, 'notifications']);

require __DIR__.'/auth.php';
