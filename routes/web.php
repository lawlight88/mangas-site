<?php

use App\Http\Controllers\{
    AppController,
    MangaController,
    CommentController,
    UserController,
    ScanlatorController
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
    
    //management
    Route::group(['prefix' => 'mgmt'], function() {
        Route::group([
            'controller' => MangaController::class,
            'as' => 'manga.',
            'prefix' => 'manga',
        ], function() {
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store');
        });

        Route::group([
            'controller' => ScanlatorController::class,
            'as' => 'scan.',
            'prefix' => 'scan',
        ], function() {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store');
            Route::put('/create', 'update');
            Route::get('/{id_scan}', 'scanView')->name('view');
        });
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
