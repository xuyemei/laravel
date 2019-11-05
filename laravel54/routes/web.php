<?php

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

//注册页面
Route::get('/register','\App\Http\Controllers\RegisterController@index');
//注册逻辑
Route::post('/register','\App\Http\Controllers\RegisterController@register');

//登录页面
Route::get('/login','\App\Http\Controllers\LoginController@index');
//登录逻辑
Route::post('/login','\App\Http\Controllers\LoginController@login');
//退出登录逻辑
Route::get('/loginout','\App\Http\Controllers\LoginController@loginOut');

//用户中心页面
Route::get('/user/me/setting','\App\Http\Controllers\UserController@setting');
//
Route::post('/user/me/settingstore','\App\Http\Controllers\UserController@settingStore');

// //文章列表
Route::get('/posts','\App\Http\Controllers\Postcontroller@index');

//创建文章
Route::get('/posts/create','\App\Http\Controllers\Postcontroller@create');
Route::post('/posts/','\App\Http\Controllers\Postcontroller@store');

//编辑文章
Route::get('/posts/{post}/edit','\App\Http\Controllers\Postcontroller@edit');
Route::put('/posts/{post}','\App\Http\Controllers\Postcontroller@update');

//删除文章
Route::get('/posts/{post}/delete','\App\Http\Controllers\Postcontroller@delete');


//文章搜索也
Route::get('/posts/search','\App\Http\Controllers\Postcontroller@search');

//文章详情页
Route::get('/posts/{post}','\App\Http\Controllers\Postcontroller@show');

Route::post('/posts/image/upload','\App\Http\Controllers\Postcontroller@imageUpload');

//
Route::post('/posts/{post}/comment','\App\Http\Controllers\Postcontroller@comment');

//赞
Route::get('/posts/{post}/zan','\App\Http\Controllers\Postcontroller@zan');
Route::get('/posts/{post}/unzan','\App\Http\Controllers\Postcontroller@unzan');

//
Route::get('user/{user}','\App\Http\Controllers\Usercontroller@show');

Route::post('user/{user}/fan','\App\Http\Controllers\Usercontroller@fan');

Route::post('user/{user}/unfan','\App\Http\Controllers\Usercontroller@unfan');


//专题详情页
Route::get('/topic/{topic}','\App\Http\Controllers\Topiccontroller@show');
//投稿
Route::post('/topic/{topic}/submit','\App\Http\Controllers\Topiccontroller@submit');

Route::get('/notices','\App\Http\Controllers\Noticecontroller@index');

//引入后台路由文件
include_once ('adminweb.php');


