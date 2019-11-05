<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 下午 1:36
 */

namespace App\Http\Controllers;
use \App\Notice;

class NoticeController extends Controller{

    public function index(){

        $user = \Auth::user();
        $notices = $user->notices;
        return view('notice.index',compact('notices'));
    }



}