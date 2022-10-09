<?php

use App\Http\Controllers\MessagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::group(['middleware' => 'auth:api'], function () {

    Route::prefix('users')->group(function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::put('/me', [UserController::class, 'edit']);
        Route::post('/logout', [UserController::class, 'logout']);
        Route::get('/@{username}', [UserController::class, 'getUserByUn']);
        Route::get('/{id}', [UserController::class, 'getUserById']);
    });

    Route::prefix('messages')->group(function () {
        Route::get('/', [MessagesController::class, 'index']);
        Route::post('/send', [MessagesController::class, 'create']);
        Route::get('/{id}', [MessagesController::class, 'getMessages']);
        Route::delete('/{id}', [MessagesController::class, 'deleteMessage']);
    });

});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});
