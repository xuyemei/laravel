<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 下午 12:36
 */

namespace App\Admin\Controllers;

class RoleController extends Controller{


    public function index(){

        $roles = \App\AdminRole::paginate(10);
        return view('admin.role.index',compact('roles'));

    }

    public function create(){

        return view('admin.role.create');

    }

    public function store(){
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required',
        ]);

        \App\AdminRole::create(request(['name','description']));

        return redirect('/admin/roles');
    }

    public function permission(\App\AdminRole $role){
        $permissions = \App\AdminPermission::all();
        $rolePermissions = $role->permissions;

        return view('admin.role.permission',compact('permissions','rolePermissions','role'));
    }

//    保存角色--权限
    public function storePermission(\App\AdminRole $role){
        $this->validate(request(),[
            'permissions'=>'required|array',
        ]);

        $permissions = \App\AdminPermission::findMany(request('permissions'));


        $rolePermissions = $role->permissions;

        $addPermissions = $permissions->diff($rolePermissions);
        $delPermissions = $rolePermissions->diff($permissions);

        foreach ($addPermissions as $addPermission){
//            dd($addPermission);
            $role->grantPermission($addPermission);
//            dd(123);
        }

        foreach ($delPermissions as $delPermission){
            $role->deletePermission($delPermission);
        }

        return back();

    }
}