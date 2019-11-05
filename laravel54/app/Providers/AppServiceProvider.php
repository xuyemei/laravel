<?php

namespace App\Providers;

use function foo\func;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        \Schema::defaultStringLength(191);

//        模板注入，在所有页面中都注入一个专题列表。
        \View::composer('layout.sidebar',function($view){
            $topics = \App\Topic::all();
            $view->with('topics',$topics);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
