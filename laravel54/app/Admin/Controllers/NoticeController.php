<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 下午 1:36
 */

namespace App\Admin\Controllers;
use \App\Notice;

class NoticeController extends Controller{

    public function index(){

        $notices = \App\Notice::all();
        return view('admin.notice.index',compact('notices'));
    }

    public function create(){


        return view('admin.notice.create');
    }

    public function store(){
        //验证
        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required',
        ]);
        //逻辑
       $notice = \App\Notice::create(request(['title','content']));

       //把新建的通知发送的队列中
        \App\Jobs\SendMessage::dispatch($notice);

        //返回
        return redirect('admin/notices');
    }



}