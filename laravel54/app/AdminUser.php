<?php

namespace App;

use App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $rememberTokenName = null;

    protected $guarded = [];


    //
    /*
     *用户有哪些角色 多对多
     * return collection
     */
    public function roles(){

        return $this->belongsToMany(\App\AdminRole::class,'admin_role_user','user_id','role_id')
            ->withPivot(['user_id','role_id']);
    }


    /*
     * 判断用户是否有某些（某个）角色
     * $roles 角色集合
     * return bool
     */
    public function isInRoles($roles){

        return !!$roles->intersect($this->roles)->count();

    }

    /*
     *给用户分配角色
     */
    public function assignRole($role){
//        往$this->>roles()这个关联关系中添加关系
        return $this->roles()->save($role);
    }

    /*
     * 给用户删除角色
     */
    public function deleteRole($role){

        //删除用户角色关联关系中的$role这个关联关系
        return $this->roles()->detach($role);
    }

    //判断用户是否有某个权限
    public function hasPermission($permission){

        return $this->isInRoles($permission->roles);

    }

}
