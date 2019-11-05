<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Zan;

class PostController extends Controller
{
    public function index(\Illuminate\Log\Writer $log){

        //使用容器模式写日志
        // $app = app();//获取一个容器
        // $log = $app->make('log');
        // $log->info('message',['data'=>'this is message log']);
         
        //采用门脸模式
        // \Log::info('message',['data'=>'this is message log']);

        // 采用依赖注入模式
        // function index(\Illuminate\Log\Writer | \Illuminate\Contracts\Logging\Log |\Psr\Log\LoggerInterface $log)
        // $log->info('message',['data'=>'this is message log']);

        $posts=Post::orderBy('created_at','desc')->withCount('comments','zans')->paginate(6);
    	return view('post/index',compact('posts'));
    }

    public function show(Post $post){

        $post->load('comments');
    	return view('post/show',compact('post'));

    }

    public function create(){

    	return view('post/create');

    }



    public function store(){

        // $post = new Post();
        // $post->title=request('title');
        // $post->content=request('content');
        // $post->save();

        // $this->validate(request(),[
        //     'title'=>'request|string|max:1000|min:3',
        //     'content'=>'request|string|min:10',
        //     ]

        //     );
        //     
        $user_id = \Auth::id();
        $params = array_merge(request(['title','content']),array('user_id'=>$user_id));
        $post = Post::create($params);//这样 写需要设置Post model里面的fillable属性

        return redirect('/posts');
    }

	//编辑页面
    public function edit(Post $post){

    	return view('post/edit',compact('post'));

    }

    //编辑逻辑
    public function update(Post $post){

        //验证
      
        //用户权限认证
        $this->authorize('update', $post);
        //逻辑
        $post->title = request('title');
        $post->content= request('content');
        $post->save();
        
        //渲染
        return redirect("/posts/{$post->id}") ;
    }

    //删除逻辑
    public function delete(POST $post){

        // to do 用户的权限认证
        // 
        // 
        $post->delete();
        return redirect('/posts');

    }

    public function imageUpload(Request $request){

        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
        dd(request()->all());

    }


    public function comment(Post $post){

        //验证
        $this->validate(request(),[
            'content'=>'required|min:3'
            ]);

        //逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $res = $post->comments()->save($comment);
        //熏染
        return back();

    }

    public function zan(Post $post){

        $params = [
            'user_id'=>\Auth::id(),
            'post_id'=>$post->id,
        ];
        Zan::firstOrCreate($params);

        return back();
    }

    public function unzan(Post $post){

         $post->zan(\Auth::id())->delete();
         
         return back();
    }


    public function search(){
        //验证
        $this->validate(request(),[

        ]);
        //逻辑
        $query=request('query');
        $posts= \App\Post::search($query)->paginate(2);

//        渲染
        return view('post/search',compact('posts','query'));
    }

}
