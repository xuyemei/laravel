<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index(){

        return view('admin/login/index');
    }

    public function login(){
        //验证
        $this->validate(request(),[
            'name'=>'required',
            'password'=>'required|min:5|max:10',
        ]);

        //逻辑
        $user = request(['name','password']);
        if(\Auth::guard('admin')->attempt($user)){
            return redirect('admin/home');
        }else{
            return \Redirect::back()->witherrors('用户名密码不匹配');
        }
        //
        //渲染
    }


    public function logOut(){
        \Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
