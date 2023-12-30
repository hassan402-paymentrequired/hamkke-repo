<?php

use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::match(['GET', 'POST'], '/site-settings', [GeneralSettingsController::class, 'siteSettings'])->name('settings.general');

    Route::get('posts', [PostsController::class, 'index'])->name('post.list');
    Route::match(['GET', 'POST'], 'posts/create', [PostsController::class, 'create'])->name('post.create');
    Route::get('posts/{post}', [PostsController::class, 'view'])->name('post.view');
    Route::match(['GET', 'POST'], 'posts/{post}/update', [PostsController::class, 'update'])->name('post.update');
    Route::post('posts/{post}/change-status', [PostsController::class, 'changeStatus'])->name('post.change_status');
});

require __DIR__.'/auth.php';
