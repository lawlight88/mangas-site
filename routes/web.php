<?php

use App\Http\Controllers\{
    AppController,
    MangaController,
    CommentController,
    UserController
};
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

//app
Route::group([
    'as' => 'app.',
    'controller' => AppController::class,
], function() {
    Route::get('/', 'index')->name('index');
    Route::get('/m/{id}', 'mangaMain')->name('manga.main');
    Route::get('/m/{id}/{chapter_order}/{page_order?}/{id_comment_edit?}', 'mangaView')->name('manga.view');
});

//user
Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'controller' => UserController::class,
], function() {
    Route::middleware('auth')->get('/edit', 'edit')->name('edit');
    Route::middleware('auth')->put('/edit', 'update');
    Route::get('/{id}', 'profile')->name('profile');
});

//auth part
Route::group(['middleware' => 'auth'], function() {
    Route::group([
        'as' => 'comment.',
        'prefix' => 'comment',
        'controller' => CommentController::class,
    ], function() {
        Route::post('/{id_chapter}', 'store')->name('store');
        Route::put('/{id_comment}', 'update')->name('update');
        Route::delete('/{id_comment}', 'delete')->name('delete');
    });

    Route::group([
        'as' => 'manga.',
        'prefix' => 'manga/mgmt', //management
        'controller' => MangaController::class,
    ], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
