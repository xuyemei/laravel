<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/2 0002
 * Time: 下午 9:55
 */

Route::group(['prefix'=>'admin'],function(){
    Route::get('/login','\App\Admin\Controllers\LoginController@index')->name('login');
    Route::post('/login','\App\Admin\Controllers\LoginController@login');
    Route::get('/logout','\App\Admin\Controllers\LoginController@logout');


//    这个group 里面的路由，都需要经过auth认证
    Route::group(['middleware'=>'auth:admin'],function(){
        //    后台首页
        Route::get('/home','\App\Admin\Controllers\HomeController@index');

        Route::group(['middleware'=>'can:system'],function(){
            //管理员页面
            Route::get('/users','\App\Admin\Controllers\UserController@index');
            Route::get('/users/create','\App\Admin\Controllers\UserController@create');
            Route::post('/users/store','\App\Admin\Controllers\UserController@store');
            //用户--角色页面
            Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/storeRole','\App\Admin\Controllers\UserController@storeRole');

            //角色列表页
            Route::get('/roles','\App\Admin\Controllers\RoleController@index');
            //新增角色页面
            Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
            //新增角色操作
            Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');
            //角色--权限页面
            Route::get('/roles/{role}/permission','\App\Admin\Controllers\RoleController@permission');
            //为角色添加权限
            Route::post('/roles/{role}/permission','\App\Admin\Controllers\RoleController@storePermission');

            //权限列表
            Route::get('/permissions','\App\Admin\Controllers\PermissionController@index');
            Route::get('/permissions/create','\App\Admin\Controllers\PermissionController@create');
            Route::post('/permissions/store','\App\Admin\Controllers\PermissionController@store');

        });

        Route::group(['middleware'=>'can:post'],function(){
            //文章列表
            Route::get('/posts','\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
        });


//            Route::get('/topics','\App\Admin\Controllers\TopicController@index');
//            Route::get('/topics/create','\App\Admin\Controllers\TopicController@create');
//            Route::post('/topics/{topic}/store','\App\Admin\Controllers\TopicController@store');
        Route::group(['middleware'=>'can:topic'],function(){
            Route::resource('topics','\App\Admin\Controllers\TopicController',
                ['only'=>['index','create','store','destory']]);
        });


        Route::group(['middleware'=>'can:notice'],function(){
            Route::resource('notices','\App\Admin\Controllers\NoticeController',
                ['only'=>['index','create','store']]);
        });





    });

});