<?php

use App\Http\Controllers\{
    AppController,
    MangaController,
    CommentController,
    UserController,
    ScanlatorController,
    RequestController,
    InviteController,
    ChapterController,
    PageController,
    FavoriteController
};
use Illuminate\Support\Facades\Route;


//app
Route::group([
    'as' => 'app.',
], function() {
    Route::group(['controller' => AppController::class], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/m/{id}', 'mangaMain')->name('manga.main');
        Route::get('/m/{id}/{chapter_order}/{page_order?}/{id_comment_edit?}', 'mangaView')->name('manga.view');
        Route::get('/genres', 'genres')->name('genres');
        Route::get('/genre/{genre_key}', 'genre')->name('genre');
        Route::get('/random', 'random')->name('random');
        Route::get('/search', 'search')->name('search');
        Route::get('/like/{manga_base}', 'moreLikeThis')->name('like.this');
    });

    Route::group(['controller' => ScanlatorController::class], function() {
        Route::get('/scans', 'allScans')->name('scans');
        Route::get('/scan/{scan}/m', 'mangasView')->name('scan.mangas');
        Route::get('/scan/{id_scan}', 'view')->name('scan.view');
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

    Route::group([
        'as' => 'favorite.',
        'prefix' => 'f',
        'controller' => FavoriteController::class
    ], function() {
        Route::post('/create/{manga}', 'store')->name('create');
        Route::delete('/remove/{manga}', 'remove')->name('remove');
        Route::get('/view', 'view')->name('view');
    });
    
    //management
    Route::group([
        'prefix' => 'mgmt',
        'middleware' => 'mgmt'
    ], function() {
        Route::group([
            'controller' => MangaController::class,
            'as' => 'manga.',
            'prefix' => 'manga',
        ], function() {
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store');
            Route::put('/{manga}', 'removeFromScan')->name('scan.remove');
            Route::get('/{manga}', 'edit')->name('edit');
            Route::get('/{manga}/edit/info', 'editInfo')->name('edit.info');
            Route::put('/{manga}/edit/info', 'updateInfo')->name('edit.info');
            Route::delete('/{manga}', 'delete')->name('delete');
        });

        Route::group([
            'controller' => ChapterController::class,
            'as' => 'chapter.',
            'prefix' => 'c',
        ], function() {
            Route::get('/{chapter}', 'edit')->name('edit');
            Route::delete('/{chapter}', 'delete')->name('delete');
            Route::post('/upload/{manga}', 'uploadPreview')->name('upload');
            Route::get('/upload/{manga}', 'continueUpload')->name('upload.continue');
            Route::put('/upload/{manga}/finish', 'upload')->name('upload.finish');
            Route::get('/cancel/{manga}', 'cancelUpload')->name('upload.cancel');
        });
        Route::group([
            'controller' => PageController::class,
            'as' => 'page.',
            'prefix' => 'p',
        ], function() {
            Route::put('/order/{manga}', 'orderOnUpload')->name('onUpload.order');
            Route::put('/edit/order/{chapter}', 'orderOnEditAndName')->name('onEdit.order&name');
            Route::get('/remove/{manga}/{order}', 'removeOnUpload')->name('onUpload.remove');
            Route::post('/add/{manga}', 'addOnUpload')->name('onUpload.add');
            Route::post('/edit/add/{chapter}', 'addOnEdit')->name('onEdit.add');
            Route::get('/display/{manga}/{order}', 'display')->name('display');
            Route::get('/edit/remove/{chapter}/{order}', 'removeOnEdit')->name('onEdit.remove');
        });

        Route::group([
            'controller' => ScanlatorController::class,
            'as' => 'scan.',
            'prefix' => 'scan',
        ], function() {
            Route::get('/', 'adminAllScans')->name('all');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store');
            Route::get('/edit/{id_scan}', 'edit')->name('edit');
            Route::put('/update/{scan}', 'update')->name('update');
            Route::delete('/delete/{scan}', 'delete')->name('delete');
            Route::get('/{id_scan}/m', 'mgmtMangasView')->name('mangas');
            Route::get('/{id_scan}/{member_edit?}', 'mgmtScanView')->name('view');
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

        Route::group([
            'controller' => InviteController::class,
            'as' => 'invite.',
            'prefix' => 'invite',
        ], function() {
            Route::post('/{id_user}', 'create')->name('create');
            Route::delete('/{id_invite}', 'cancel')->name('cancel');
            Route::put('/refuse/{id_invite}', 'refuse')->name('refuse');
            Route::put('/accept/{id_invite}', 'accept')->name('accept');
        });

        Route::group([
            'as' => 'user.scan.',
            'prefix' => 'user',
            'controller' => UserController::class,
        ], function() {
            Route::put('/remove{id_user}', 'removeFromScan')->name('remove');
            Route::put('/{member}', 'editScanRole')->name('role.edit');
        });
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
