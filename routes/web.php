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

Route::controller(AppController::class)
                ->as('app.')
                ->group(function() {
                    Route::get('/', 'index')->name('index');
                    Route::get('/m/{id}', 'mangaMain')->name('manga.main');
                    Route::get('/m/{id}/{chapter_order}/{page_order?}/{id_comment_edit?}', 'mangaView')->name('manga.view');
});

Route::controller(MangaController::class)
                ->as('manga.')
                ->prefix('manga')
                ->middleware('auth')
                ->group(function() {
                    Route::get('/', 'create')->name('create');
                    Route::post('/', 'store');
});

Route::controller(CommentController::class)
                ->as('comment.')
                ->prefix('comment')
                ->middleware('auth')
                ->group(function() {
                    Route::post('/{id_user}/{id_chapter}', 'store')->name('store');
                    Route::put('/{id_comment}', 'update')->name('update');
});

Route::controller(UserController::class)
                ->as('user.')
                ->prefix('user')
                ->group(function() {
                    Route::get('/{id}', 'profile')->name('profile');
                    Route::middleware('auth')->get('/{id}/edit', 'edit')->name('edit');
                    Route::middleware('auth')->put('/{id}/edit', 'update');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
