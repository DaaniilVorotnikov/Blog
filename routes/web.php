<?php

use App\Http\Controllers\Blog\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestTestController;
use App\Http\Controllers\Blog\Admin\PostController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('blog')->group(function(){
    Route::resource('posts', PostController::class)->names('blog.posts');
});

Route::resource('rest', RestTestController::class)->names('restTest');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin/blog')->group(function(){
    //BlogCategory
    $mehods = ['index', 'edit', 'store', 'update', 'create',];
    Route::resource('categories', CategoryController::class)
        ->only($mehods)
        ->names('blog.admin.categories');

    //BlogPost
    Route::resource('posts', PostController::class)
        ->except(['show'])
        ->names('blog.admin.posts');
});