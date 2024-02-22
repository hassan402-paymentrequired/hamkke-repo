<?php

use App\Http\Controllers\Admin\CategoriesCrudController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForumPostsController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\TagsCrudController;
use App\Http\Controllers\Customer\AuthenticationContoller;
use App\Http\Controllers\Front\ForumCrudController;
use App\Http\Controllers\Front\PostsController as FrontPostsController;
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
$adminRoutes = function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'home'])->middleware(['auth', 'verified']);

    Route::middleware('auth')->group(function () {
        Route::match(['GET', 'POST'], '/site-settings', [GeneralSettingsController::class, 'siteSettings'])
            ->name('settings.general');

        // Start Admin-Post Management Routes
        Route::get('posts', [PostsController::class, 'index'])->name('admin.post.list');
        Route::match(['GET', 'POST'], 'posts/create', [PostsController::class, 'create'])->name('admin.post.create');
        Route::get('posts/{post:id}', [PostsController::class, 'preview'])->name('admin.post.preview');
        Route::match(['GET', 'POST'], 'posts/{post:id}/update', [PostsController::class, 'update'])
            ->name('admin.post.update');
        Route::post('posts/{post:id}/change-status', [PostsController::class, 'changeStatus'])
            ->name('admin.post.change_status');
        Route::post('posts/{post:id}/delete', [PostsController::class, 'delete'])->name('admin.post.delete');

        // Start Admin-Category Management Routes
        Route::get('categories', [CategoriesCrudController::class, 'index'])->name('admin.category.list');
        Route::post('categories/create', [CategoriesCrudController::class, 'saveCategory'])->name('admin.category.create');
        Route::post('categories/{category:id}/update', [CategoriesCrudController::class, 'updateCategory'])->name('admin.category.update');
        Route::post('categories/{category:id}/delete', [CategoriesCrudController::class, 'deleteCategory'])->name('admin.category.delete');

        // Start Admin-Tag Management Routes
        Route::get('tags', [TagsCrudController::class, 'index'])->name('admin.tag.list');
        Route::post('tags/create', [TagsCrudController::class, 'store'])->name('admin.tag.create');
        Route::post('tags/{tag:id}/update', [TagsCrudController::class, 'update'])->name('admin.tag.update');
        Route::post('tags/{tag:id}/delete', [TagsCrudController::class, 'destroy'])->name('admin.tag.delete');

        // Start Admin-User Management Routes
        Route::get('users', [UsersController::class, 'index'])->name('admin.user.list');
        Route::match(['GET', 'POST'], 'users/create', [UsersController::class, 'create'])
            ->name('admin.user.create');
        Route::match(['GET', 'POST'], 'users/{user}/update', [UsersController::class, 'update'])
            ->name('admin.user.update');
        Route::post('users/{user}/activate', [UsersController::class, 'activate'])->name('admin.user.activate');
        Route::post('users/{user}/deactivate', [UsersController::class, 'deactivate'])->name('admin.user.deactivate');
        Route::post('users/{user}/delete', [UsersController::class, 'delete'])->name('admin.user.delete');
        // End User Management Routes

        Route::prefix('forum')->group(function () {
            // Start Admin Forum-Post Management Routes
            Route::get('threads', [ForumPostsController::class, 'index'])->name('admin.forum-post.list');
            Route::match(['GET', 'POST'], 'threads/create', [ForumPostsController::class, 'create'])->name('admin.forum-post.create');
            Route::get('threads/preview/{forumPost:id}', [ForumPostsController::class, 'preview'])->name('admin.forum-post.preview');
            Route::post('threads/archive/{forumPost:id}', [ForumPostsController::class, 'changeStatus'])
                ->name('admin.forum-post.change_status');
            Route::post('threads/delete/{forumPost:id}', [ForumPostsController::class, 'delete'])->name('admin.forum-post.delete');
        });
    });

    require __DIR__.'/auth.php';
};

Route::domain(config('app.admin_domain'))->group( $adminRoutes );

Route::domain(config('app.default_domain'))->group( function () use ($adminRoutes) {
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('/about-us', [PagesController::class, 'about'])->name('about_us');
    Route::post('/contact-us', [PagesController::class, 'submitContactRequest'])->name('contact_us');
    Route::get('/pt/{post_type}/{post_category?}', [FrontPostsController::class, 'postsByPostCategory'])->name('post_type.view');
//    Route::get('/category/{post_category}', [FrontPostsController::class, 'postsByPostType'])->name('post_category.view');
    // Route::get('/tag/{post_tag}', [PagesController::class, 'home'])->name('post_type.view')
    Route::get('/posts', [PagesController::class, 'home'])->name('post.list');
    Route::get('/posts/{post}', [FrontPostsController::class, 'singlePost'])->name('post.view');

    Route::post('/comment/{post}', [FrontPostsController::class, 'postComment'])->name('post.comment.add');
    Route::prefix('admin')->group($adminRoutes);

    Route::prefix('forum')->group(function (){
        Route::get('/', [ForumCrudController::class, 'index'])->name('forum.posts');
        Route::post('/start-discussion', [ForumCrudController::class, 'createThread'])->name('forum.posts.create');
        Route::get('/{forumPost:slug}', [ForumCrudController::class, 'viewPost'])->name('forum.posts.view');
        Route::post('/comment/{forumPost:slug}', [ForumCrudController::class, 'replyThread'])->name('forum.posts.reply');
    });

    Route::middleware('guest:' . CUSTOMER_GUARD_NAME)->group(function (){
        Route::match(['get', 'post'], '/login', [AuthenticationContoller::class, 'login'])->name('customer.auth.login');
        Route::match(['get', 'post'], '/register', [AuthenticationContoller::class, 'register'])->name('customer.auth.register');
    });
    Route::post('/logout', [AuthenticationContoller::class, 'logout'])->name('customer.auth.logout');
});

