<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index(){

    	return view('login/index');
    }

    public function login(){
    	//验证
    	$this->validate(request(),[
    		'email'=>'required|email',
    		'password'=>'required|min:5|max:10',
    		'is_remember'=>'integer'
    		]);

    	//逻辑
    	$user = request(['email','password']);
    	$is_remember = boolval(request('is_remember'));
    	if(\Auth::attempt($user,$is_remember)){
    		return redirect('posts');
    	}else{
    		return \Redirect::back()->witherrors('邮箱密码不匹配');
    	}
    	//
    	//渲染
    	return ;
    }


    public function loginOut(){
    	\Auth::logout();
    	return redirect('/login');
    }
}
