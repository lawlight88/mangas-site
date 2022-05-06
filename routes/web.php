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
                    Route::post('/{id_chapter}', 'store')->name('store');
                    Route::put('/{id_comment}', 'update')->name('update');
                    Route::delete('/{id_comment}', 'delete')->name('delete');
});

Route::controller(UserController::class)
                ->as('user.')
                ->prefix('user')
                ->group(function() {
                    Route::middleware('auth')->get('/edit', 'edit')->name('edit');
                    Route::middleware('auth')->put('/edit', 'update');
                    Route::get('/{id}', 'profile')->name('profile');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
