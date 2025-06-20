<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CommentAgreeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ThreadsController::class, 'index']);

Route::get('/dashboard', [ThreadsController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    Route::get('/users/{id}/edit', [UsersController::class, 'edit']) -> name('users.edit');
    Route::put('/users/{id}', [UsersController::class, 'update']) -> name('users.update');

    Route::prefix('threads')->group(function () {
        Route::post('/{id}/create', [CommentsController::class, 'store'])->name('comments.store');
        Route::delete('/{id}/delete', [CommentsController::class, 'destroy'])->name('comments.delete');
        Route::get('/{id}', [ThreadsController::class, 'show'])->name('threads.show');
        Route::post('/{id}/agree', [CommentsController::class, 'agree'])->name('comments.agree');
    });

    Route::resource('threads', ThreadsController::class, ['only' => ['store', 'destroy']]);
});

require __DIR__.'/auth.php';
