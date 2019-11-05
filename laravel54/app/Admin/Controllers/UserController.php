<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 下午 12:36
 */

namespace App\Admin\Controllers;
use \App\AdminUser;
class UserController extends Controller{

    //管理员列表
    public function index(){

        $users = AdminUser::paginate(10);
        return view('admin.user.index',compact('users'));
    }

//    新增管理员页面
    public function create(){
        return view('admin.user.create');

    }
//提交新增管理员
    public function store(){
        $this->validate(request(),[
            'name'=>'required|min:3',
            'password'=>'required',
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name','password'));

        return redirect('/admin/users');

    }

    //用户--角色列表
    public function role(\App\AdminUser $user){
        $roles = \App\AdminRole::all();
        $myroles = $user->roles;
        return view('admin.user.role',compact('roles','myroles','user'));

    }

//    保存用户--角色
    public function storeRole(\App\AdminUser $user){
        $this->validate(request(),[
            'roles'=>'required|array',
        ]);

        //选中的所有role
        $roles = \App\AdminRole::findMany(request('roles'));
        $myroles = $user->roles;//adminuser 已经有的role

        //新增的role
        $addRoles = $roles->diff($myroles);

        //减去的role
        $delRoles = $myroles->diff($roles);

        foreach ($addRoles as $addRole){
            $user->assignRole($addRole);
        }

        foreach ($delRoles as $delRole){
            $user->deleteRole($delRole);
        }

        return back();

    }
}