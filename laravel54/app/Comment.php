<?php

namespace App;

use App\Model;

class Comment extends Model
{
    //评论文章关联，一对多反向
    public function posts(){

    	return $this->belongsTo('App\Post');

    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
