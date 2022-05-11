<?php

use App\Http\Controllers\{
    AppController,
    MangaController,
    CommentController,
    UserController,
    ScanlatorController,
    RequestController
};
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

//app
Route::group([
    'as' => 'app.',
], function() {
    Route::group(['controller' => AppController::class], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/m/{id}', 'mangaMain')->name('manga.main');
        Route::get('/m/{id}/{chapter_order}/{page_order?}/{id_comment_edit?}', 'mangaView')->name('manga.view');
    });

    Route::group(['controller' => ScanlatorController::class], function() {
        Route::get('/scans', 'allScans')->name('scans');
        Route::get('/scan/{scan}', 'view')->name('scan.view');
    });
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
        Route::put('/{comment}', 'update')->name('update');
        Route::delete('/{comment}', 'delete')->name('delete');
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
            Route::get('/', 'adminAllScans')->name('all');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store');
            Route::put('/update/{scan}', 'update')->name('update');
            Route::delete('/delete/{scan}', 'delete')->name('delete');
            Route::get('/{id_scan}', 'mgmtScanView')->name('view');
        });

        Route::group([
            'controller' => RequestController::class,
            'as' => 'request.',
            'prefix' => 'requests',
        ], function() {
            Route::get('/', 'scanRequests')->name('scan');
            Route::get('/admin', 'adminRequests')->name('admin');
            Route::get('/history', 'history')->name('history');
            Route::post('/create/{id_manga}', 'store')->name('create');
            Route::delete('/cancel/{id_req}', 'cancel')->name('cancel');
            Route::put('/accept/{id_req}', 'accept')->name('accept');
            Route::put('/refuse/{id_req}', 'refuse')->name('refuse');
        });
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
