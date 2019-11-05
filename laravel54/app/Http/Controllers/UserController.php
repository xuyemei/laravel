<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setting(){
    	return view('user/setting');
    }

    public function settingStore(){
    	return ;
    }

//    个人中心
    public function show(User $user){
        // 这个人的信息，包含关注，粉丝，文章数
        $user = User::withCount(['stars','fans','posts'])->find($user->id);//user模型
        // 这个人的文章列表
        $posts = $user->posts()->orderBy('created_at')->take(10)->get();

        //这个人关注的用户，以及关注的人的关注，粉丝，文章数
        $stars = $user->stars();//fan模型中的star
        $susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();
        // 这个人的粉丝，包含粉丝的关注，粉丝，文章数
        $fans = $user->fans();//fan模型中的fan
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();

        return view('user/show',compact('user','posts','susers','fusers'));

//        // 这个人的文章
//        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
//        // 这个人的关注／粉丝／文章
//        $user = \App\User::withCount(['stars', 'fans', 'posts'])->find($user->id);
//        $fans = $user->fans()->get();
//        $stars = $user->stars()->get();
//
//        return view("user/show", compact('user', 'posts', 'fans', 'stars'));
    }


//    赞
    public function fan(User $user){
        $me = \Auth::user();
        $me->doFan($user->id);
        return [
            'error'=>0,
            'msg'=>''
        ];
    }

//    取消赞
    public function unfan(User $user){
        $me = \Auth::user();
        $me->doUnFan($user->id);
        return [
            'error'=>0,
            'msg'=>''
        ];
    }
}
