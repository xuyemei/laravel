<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 下午 1:36
 */

namespace App\Admin\Controllers;
use \App\Topic;

class TopicController extends Controller{

    public function index(){

        $topics = \App\Topic::all();
        return view('admin.topic.index',compact('topics'));
    }

    public function create(){


        return view('admin.topic.create');
    }

    public function store(){
        //验证
        $this->validate(request(),[
            'name'=>'required',
        ]);
        //逻辑
        \App\Topic::create(['name'=>request('name')]);
        //返回
        return redirect('admin/topics');
    }

    public function destory(\App\Topic $topic){

        $topic->delete();
        return [
            'error'=>0,
            'msg'=>'',
        ];
    }

}