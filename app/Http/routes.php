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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/gitLogin', 'LoginController@github');
Route::get('/github/login', 'LoginController@githubLogin');

Route::get('/weChatLogin', 'LoginController@weChat');
Route::get('/weChat/login', 'LoginController@weChatLogin');

Route::any('/wechat', 'WechatController@serve');

Route::get('/users', 'WeChat\UserController@users');
Route::get('/user/{userId}', 'WeChat\UserController@user');
