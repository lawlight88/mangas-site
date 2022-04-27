<?php

use App\Http\Controllers\{
    AppController,
    MangaController
};
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(AppController::class)
                ->as('app.')
                ->group(function() {
                    Route::get('/', 'index')->name('index');
});

Route::controller(MangaController::class)
                ->as('manga.')
                ->prefix('manga')
                ->middleware('auth')
                ->group(function() {
                    Route::get('/', 'create')->name('create');
                    Route::post('/', 'store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
