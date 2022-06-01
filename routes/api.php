<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    APIController,
    Auth\AuthAPIController
};


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

Route::group(['controller' => AuthAPIController::class], function() {
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->delete('/logout', 'logout');
});

Route::group(['controller' => APIController::class], function() {

    Route::get('/user/{id_user}/comments', 'userComments');

    Route::group(['prefix' => 'mangas'], function() {
        Route::get('/{id_manga?}', 'mangas');
        Route::get('/{id_manga}/chapters', 'chapters');
        Route::get('/{id_manga}/chapters/{chapter_order}/comments', 'chaptersComments');
        Route::get('/search/{search}', 'mangasSearch');
    });

    Route::group(['middleware' => 'auth:sanctum'], function() {
        
        Route::get('/user/{id_user}/favorites', 'userFavorites');

        Route::group(['prefix' => 'mangas'], function() {
            Route::post('/{id_manga}/chapters/{chapter_order}/comments', 'createComment');
            Route::get('/{id_manga}/temp', 'mangaTempFiles');
        });

        Route::group(['prefix' => 'comments'], function() {
            Route::put('/{id_comment}', 'commentEdit');
            Route::delete('/{id_comment}', 'commentDelete');
        });
    });
});
