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

//Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/gitLogin', 'LoginController@github');
Route::get('/github/login', 'LoginController@githubLogin');

Route::get('/weChatLogin', 'LoginController@weChat');
Route::get('/weChat/login', 'LoginController@weChatLogin');

Route::any('/wechat', 'WechatController@serve');

Route::get('/users', 'WeChat\UserController@users');
Route::get('/user/{userId}', 'WeChat\UserController@user');


Route::get('/login', function () {
    return view('user.auth.login');
});

Route::group(['prefix'=> 'admin'], function () {
    Route::get('userList', 'Web\User\UserController@userList');
    Route::resource('user','Web\User\UserController');

    Route::resource('productType', 'Web\Product\ProductTypeController');
    Route::post('addType', 'Web\Product\ProductTypeController@addProductType');
    Route::post('type', 'Web\Product\ProductTypeController@findType');
    Route::group(['prefix' => 'product'], function() {
        Route::post('avatar', 'Web\Product\ProductController@avatar');
    });

    Route::resource('product', 'Web\Product\ProductController');
});

Route::get('/aaa', function() {
    $arr = [
        'email'     => '657884402@111.com',
        'username'  => '大帅锅',
        'password'  => '123456abc',
        'captcha'   => '1234'
    ];

//    $json = \App\Services\UserService::emailRegister($arr);
//    $json = \App\Services\ECoreService::rand_string(6,4);
//    dd($json);
//    $user = \App\Services\UserService::accountTypeAndInfo('eryn65@example.net');
//    $password = \App\Services\UserService::encrypt('123456', '$2y$10$VAXXiwwTKsELgmFIHBhCIeFvzDx5Rt7jUAkBPq.eIq97EnHDRgDO');
//    $user = \App\Services\UserService::login('657884402@1112.com', '123456abc');
//    $content = '我知道你是傻逼我知道你是傻逼我知道你是傻逼我知道你是傻逼我知道你是傻逼我知道你是傻逼我知道你是傻逼';
//    $deconde = '6d63VFECVFZSAghRAwJXDlYBUQUDAF0AU1pcB1SHv/SD+52N4KGA28LUoM7WtYnRsI2C66DUpsaLufbT38HR/cuBut+IstiA6qPf/pbes6vUjMSFqZzc4dnR5YuE6aaC+8HR5fLW2caEqpeEsYzbuIzX7PLWrJyK46uBisKHr8qB5oON4Y6C7vPVp8TatqHcjZGC+57Wu9iLuNnR6vDQ+sGNufeFj8SA+p3d44jesoQ';
//    dd(\App\Services\ECoreService::sys_auth($deconde,'DECODE'));
//    return $user;
//    return view('backstage.user.userlist');
//    dd($items);
    dd();
    return redirect('/bbb');
});

Route::get('/bbb', function (\Illuminate\Http\Request $request) {
//    fa59d2b94e355a8b5fd0c6bac0c81be5
    dd($request->session()->all());
dd('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
    dd(Auth::user());
});
