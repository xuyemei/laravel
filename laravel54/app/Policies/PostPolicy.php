<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

/*

    post 的权限类

 */
class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


//定义修改权限
    public function update(User $user,Post $post){
        return $user->id == $post->user_id;
    }
//定义删除权限
    public function delete(User $user,Post $post){
        return $user->id == $post->user_id;
    }
}
