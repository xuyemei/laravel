<?php

namespace App;

use \App\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';

    //角色下的所有权限
    public function permissions(){
        return $this->belongsToMany(\App\AdminPermission::class,'admin_permission_role','role_id','permission_id')
            ->withPivot(['permission_id','role_id']);
    }

//    给角色赋$permission的权限
    public function grantPermission($permission){
//        dd($permission);
//        dd($this->permissions());
        return $this->permissions()->save($permission);
    }

    //给角色删除$permission的权限
    public function deletePermission($permission){
        return $this->permissions()->detach($permission);
    }


//    判断角色中是否有$peimission的权限
    public function hasPermission($permission){
        return $this->permissions()->contains($permission);
    }


}
