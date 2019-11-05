<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
   protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        
        // 把App\Policies\PostPolicy策略类注册到App\Post模型中
        'App\Post'=>'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissions = \App\AdminPermission::all();
        foreach($permissions as $permission){
            Gate::define($permission->name,function ($user) use($permission){
                return $user->hasPermission($permission);
            });
        }

    }
}
