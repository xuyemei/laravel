<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostTopic;
use App\Topic;

class TopicController extends Controller
{
    //
    public function show(Topic $topic){

//        带文章数的专题信息
        $topic = Topic::withCount('postTopics')->find($topic->id);

//        专题下的文章列表，按文章时间倒叙排序,获取最新10条记录
        $posts = $topic->posts()->orderBy('created_at','desc')->take(10)->get();
        //属于我并且未投稿的文章
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();
        return view('topic/show',compact('topic','posts','myposts'));
    }

    public function submit(Topic $topic){
//        验证
        $this->validate(\request(),[
           'post_is'=>'requird|array'
        ]);

        $post_ids = \request('post_ids');
        $topic_id = $topic->id;
        foreach($post_ids as $post_id){
            \App\PostTopic::firstOrCreate(['topic_id'=>$topic_id,'post_id'=>$post_id]);
        }
        return back();
    }
}
