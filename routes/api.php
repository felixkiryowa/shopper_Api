<?php

// use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('items', 'ItemController@store');
// Route::get('posts', 'ItemController@get_all_items');
// Route::get('posts/{id}', 'ItemController@get_single_items');

// Route::get('posts', 'PostController@get_all_posts');
// Route::get('post/{id}', 'PostController@get_single_post');
// Route::post('post/create', 'PostController@store');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('sendPasswordResetLink', 'RequestPasswordResetController@send_email');

});

