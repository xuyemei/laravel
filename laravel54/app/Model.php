<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	 protected $guarded = [];//使用create()方法不可以注入的数据库字段
}