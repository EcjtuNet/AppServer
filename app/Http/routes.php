<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
 * dingo/api init
 */
$api = app('Dingo\Api\Routing\Router');


Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/login', ['as' => 'admin_login', 'uses' => 'LoginController@showLogin']);
Route::post('admin/login', 'LoginController@doLogin');
Route::get('download', 'IndexController@download');
Route::get('/', 'IndexController@show');

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin_'], function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@show']);
    Route::get('article', ['as' => 'article_list', 'ueses' => 'ArticleController@showList']);
    Route::get('article/new', 'ArticleController@showNew');
    Route::post('article', 'ArticleController@submit');
    Route::get('article/{id}/publish', 'ArticleController@publish');
    Route::get('article/{id}/cancel', 'ArticleController@cancel');
    Route::get('article/{id}', ['as' => 'show_article', 'uses' => 'ArticleController@show']);
    Route::post('article/{id}', 'ArticleController@edit');
    Route::get('article/{id}/edit', 'ArticleController@showEdit');
    Route::get('article/{id}/delete', 'ArticleController@delete');
    Route::get('comment', ['as' => 'comment_list', 'uses' => 'CommentController@showList']);
    Route::get('comment/{id}/delete', 'CommentController@delete');
    Route::get('push', ['as' => 'push_list', 'uses' => 'PushController@showList']);
    Route::post('push', 'PushController@submit');
    Route::get('category', ['as' => 'category_list', 'uses' => 'CategoryController@showList']);
    Route::post('category', 'CategoryController@submit');
    Route::post('category/{id}', 'CategoryController@edit');
    Route::get('setting', ['as' => 'setting', 'uses' => 'SettingController@show']);
    Route::post('setting', 'SettingController@submit');
    Route::post('image', 'ImageController@submit');
    Route::get('feedback', 'FeedbackController@showList');
});

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'ApiLog'], function ($api){
        $api->get('index', 'App\Api\Controllers\IndexController@showIndex');
        $api->get('schoolnews', 'App\Api\Controllers\IndexController@showSchoolnews');
        $api->get('articles', 'App\Api\Controllers\ArticleController@showList');
        $api->get('article/{id}', 'App\Api\Controllers\ArticleController@show');
        $api->get('article/{id}/view', ['as' => 'article_view', 'uses' => 'App\Http\Controllers\ArticleController@showView']);//注意这里使用的是Api\Http
        $api->get('article/{id}/comments', 'App\Http\Controllers\CommentController@showComments');//注意这里使用的是Api\Http
        $api->post('article/{id}/comment', 'App\Api\Controllers\CommentController@submit');
        $api->get('version', 'App\Api\Controllers\VersionController@show');
        $api->post('feedback', 'App\Api\Controllers\FeedbackController@submit');
    });
    
});
