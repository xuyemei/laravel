<?php

namespace App;

use App\Model;
use Faker\Provider\Biased;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{

    use Searchable;

    /*
     * 定义索引里面的type
     */
    public function SearchalbeAs(){
        return 'post';
    }

    /*
     * 定义需要搜索的字段
     *
     */
    public function toSearchableArray()
    {
        return [
            'title'=>$this->title,
            'content'=>$this->content,
        ];
    }

    /*
     * 使用命令行导入post数据到es
     * php artisan scout:import '\App\Post'
     */

    // protected $guarded = [];//使用create()方法不可以注入的数据库字段
    //protected $fillable=['title','post'];//可以使用create()方法注入的数据库字段
    //文章用户关联，一对多反向
    public function user(){
    	return $this->belongsTo('App\User');
    }


//文章评论模型关联，一对多
    public function comments(){
    	return $this->hasMany('App\Comment')->orderBy('created_at','desc');
    }


//文章对user_id 是否有赞
    public function zan($user_id){

    	return $this->hasOne(Zan::class)->where('user_id',$user_id);

    }

// 文章的所有赞
    public function zans(){
    	return $this->hasMany(Zan::class);
    }

//    属于某个作者的文章
    public function scopeAuthorBy(Builder $query,$user_id){
        return $query->where('user_id',$user_id);
    }


    public function postTopics(){
        return $this->hasMany(\App\PostTopic::class,'post_id','id');
    }

    //scope某篇文章不属于某个专题
    public function scopeTopicNotBy(Builder $query,$topic_id){
        return $query->doesntHave('postTopics','and',function($q) use ($topic_id) {
            $q->where('topic_id',$topic_id);

        });
    }

    //全局scope的方式
    protected static function boot(){
        parent::boot();
        static::addGlobalScope('avaiable',function (Builder $builder){
            $builder->whereIn('status',[0,1]);
        });
    }
}
