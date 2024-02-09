<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
//    Route::crud('tags', 'TagsCrudController');
//    Route::crud('categories', 'CategoriesCrudController');
//    Route::crud('user', 'UserCrudController');
}); // this should be the absolute last line of this file
