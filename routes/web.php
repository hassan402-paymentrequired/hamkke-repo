<?php

use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Front\PagesController;
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
Route::domain(config('app.admin_domain'))->group( function () {
    Route::get('/', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::match(['GET', 'POST'], '/site-settings', [GeneralSettingsController::class, 'siteSettings'])
            ->name('settings.general');

        Route::get('posts', [PostsController::class, 'index'])->name('admin.post.list');
        Route::match(['GET', 'POST'], 'posts/create', [PostsController::class, 'create'])->name('admin.post.create');
        Route::get('posts/{post:id}', [PostsController::class, 'preview'])->name('admin.post.view');
        Route::match(['GET', 'POST'], 'posts/{post:id}/update', [PostsController::class, 'update'])
            ->name('admin.post.update');
        Route::post('posts/{post:id}/change-status', [PostsController::class, 'changeStatus'])
            ->name('admin.post.change_status');
        Route::post('posts/{post:id}/delete', [PostsController::class, 'delete'])->name('admin.post.delete');

        Route::get('post-categories', [PostsController::class, 'categories'])->name('admin.category.list');
        Route::post('post-categories/create', [PostsController::class, 'saveCategory'])->name('admin.category.create');
        Route::post('post-categories/{category:id}/update', [PostsController::class, 'updateCategory'])->name('admin.category.update');
        Route::post('post-categories/{category:id}/delete', [PostsController::class, 'deleteCategory'])->name('admin.category.delete');

        Route::get('post-tags', [PostsController::class, 'tags'])->name('admin.tag.list');
        Route::post('post-tags/create', [PostsController::class, 'saveTag'])->name('admin.tag.create');
        Route::post('post-tags/{tag:id}/update', [PostsController::class, 'updateTag'])->name('admin.tag.update');

        // Start User Management Routes
        Route::get('users', [UsersController::class, 'index'])->name('admin.user.list');
        Route::match(['GET', 'POST'], 'users/create', [UsersController::class, 'create'])
            ->name('admin.user.create');
        Route::match(['GET', 'POST'], 'users/{user}/update', [UsersController::class, 'update'])
            ->name('admin.user.update');
        Route::post('users/{user}/activate', [UsersController::class, 'activate'])->name('admin.user.activate');
        Route::post('users/{user}/deactivate', [UsersController::class, 'deactivate'])->name('admin.user.deactivate');
        Route::post('users/{user}/delete', [UsersController::class, 'delete'])->name('admin.user.delete');
        // End User Management Routes
    });

    require __DIR__.'/auth.php';
});

Route::domain(config('app.default_domain'))->group( function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('/about-us', [PagesController::class, 'about'])->name('about_us');
    Route::post('/contact-us', [PagesController::class, 'submitContactRequest'])->name('contact_us');
    Route::get('/pt/{post_type}', [PagesController::class, 'home'])->name('post_type.view');
    Route::get('/category/{post_category}', [PagesController::class, 'home'])->name('post_category.view');
    // Route::get('/tag/{post_tag}', [PagesController::class, 'home'])->name('post_type.view')
    Route::get('/posts', [PagesController::class, 'home'])->name('post.list');
    Route::get('/posts/{post}', [PagesController::class, 'home'])->name('post.view');
});

