<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'App\Http\Controllers\AuthController@register');
    Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::middleware('auth:sanctum')->post('/logout', 'App\Http\Controllers\AuthController@logout');
});
//User
Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'App\Http\Controllers\UserController@get_users');
    Route::get('/{user_id}', 'App\Http\Controllers\UserController@get_user');
    Route::middleware('auth:sanctum')->post('/', 'App\Http\Controllers\UserController@new_user');
    Route::middleware('auth:sanctum')->patch('/{user_id}', 'App\Http\Controllers\UserController@update_user');
    Route::middleware('auth:sanctum')->delete('/{user_id}', 'App\Http\Controllers\UserController@delete_user');
});
//Post
Route::group(['prefix' => 'posts'], function () {
    Route::get('/', 'App\Http\Controllers\PostController@get_posts');
    Route::get('/{post_id}', 'App\Http\Controllers\PostController@get_post');
    Route::get('/{post_id}/comments', 'App\Http\Controllers\PostController@get_comments');
    Route::middleware('auth:sanctum')->post('/{post_id}/comments', 'App\Http\Controllers\PostController@create_comment');
    Route::get('/{post_id}/like', 'App\Http\Controllers\PostController@get_likes');
    Route::middleware('auth:sanctum')->post('/', 'App\Http\Controllers\PostController@create_post');
    Route::middleware('auth:sanctum')->post('/{post_id}/like', 'App\Http\Controllers\PostController@create_like');
    Route::middleware('auth:sanctum')->patch('/{post_id}', 'App\Http\Controllers\PostController@update_post');
    Route::middleware('auth:sanctum')->delete('/{post_id}', 'App\Http\Controllers\PostController@delete_post');
    Route::middleware('auth:sanctum')->delete('/{post_id}/like', 'App\Http\Controllers\PostController@delete_like');
});
//Categories
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'App\Http\Controllers\CategoryController@get_categories');
    Route::get('/{category_id}', 'App\Http\Controllers\CategoryController@get_category');
    Route::middleware('auth:sanctum')->post('/', 'App\Http\Controllers\CategoryController@create_category');
    Route::middleware('auth:sanctum')->patch('/{category_id}', 'App\Http\Controllers\CategoryController@update_category');
    Route::middleware('auth:sanctum')->delete('/{category_id}', 'App\Http\Controllers\CategoryController@delete_category');
});
//Comments
Route::group(['prefix' => 'comments'], function () {
    Route::get('/{comment_id}', 'App\Http\Controllers\CommentController@get_comment');
    Route::get('/{comment_id}/like', 'App\Http\Controllers\CommentController@get_likes');
    Route::middleware('auth:sanctum')->post('/{comment_id}/like', 'App\Http\Controllers\CommentController@create_like');
    Route::middleware('auth:sanctum')->patch('/{comment_id}', 'App\Http\Controllers\CommentController@update_comment');
    Route::middleware('auth:sanctum')->delete('/{comment_id}', 'App\Http\Controllers\CommentController@delete_comment');
    Route::middleware('auth:sanctum')->delete('/{comment_id}/like', 'App\Http\Controllers\CommentController@delete_like');
});
