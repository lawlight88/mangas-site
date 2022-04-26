<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(AppController::class)
                ->as('app.')
                ->group(function() {
                    Route::get('/', 'index')->name('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
