<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 下午 12:36
 */

namespace App\Admin\Controllers;

class PermissionController extends Controller{


    public function index(){

        $permissions = \App\AdminPermission::paginate(10);
        return view('admin.permission.index',compact('permissions'));
    }

    public function create(){
        return view('admin.permission.create');
    }

    public function store(){

        $this->validate(request(),[
            'name'=>'required',
            'description'=>'required'
        ]);

        \App\AdminPermission::create(request(['name','description']));

        return redirect('admin/permissions');

    }

}