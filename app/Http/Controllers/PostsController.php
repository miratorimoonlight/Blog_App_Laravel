<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /* 
       this is to filter out guest request 
       to do stuff with the Posts like edit, delete, create
       but except for index() and show() function
    */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['index','show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // cannot use paginate() in all()
        // $posts = Post::all();
        // $posts = Post::orderBy('title','asc')->get();

        $posts = Post::orderBy('created_at','desc')->paginate(5);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this-> validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        //create a new record and store
        $post = new Post;
        //Rule:
        //$request->input('parameter_name_of_<input>')
        //...in this case it is 'title'
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->save();
        
        //'success' is the key linked to the one in messages.blade.php 
        //with value 'New Blog Created'
        //Rule: redirect('url')
        return redirect('posts')->with('success','New Blog Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //filter by title
        //$post = Post::where('title','My blog')->get();
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = auth()->user()->id;
        $post = Post::find($id);

        //Check for correct user to see edit page
        if ($user_id == $post->user_id)
        {
            return view("posts.edit")->with('post',$post);
        }
        else{
            return redirect("/posts")->with('err','Unauthorized Page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this-> validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        //create a new record and store
        $post = Post::find($id);
        //Rule:
        //$request->input('parameter_name_of_<input>')
        //...in this case it is 'title'
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        //this means: redirect()->action()->with();
        return redirect()
            ->action('PostsController@show',['id' => $post->id])
            ->with('success','Blog Updated');

        //'success' is the key linked to the one in messages.blade.php 
        //with value 'New Blog Created'
        //Rule: redirect('url')
        // return redirect('/posts/{$post->id}')->with('success','Blog Updated');
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find($id);
        //Check for correct user to see edit page
        if (auth()->user()->id == $post->user_id)
        {
            $post->delete();
            return redirect('/posts')->with('success','Blog Deleted');
        }
        else{
            return redirect("/posts")->with('err',"Cannot delete other's post");
        }
        
    }
}
