<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 上午 8:58
 */
namespace App\Admin\Controllers;

use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index(){
        return view('admin.home.index');
    }

}