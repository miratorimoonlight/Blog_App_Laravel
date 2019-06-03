<?php

namespace Blog_Website_Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Blog_Website_Laravel\Post;


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
            'body'=>'required',
            //file uploaded must be image file and can be optional
            'image'=> 'image|nullable',
        ]);

        //Handle uploaded file
        //hasFile('html_attribute/param') checks if there is file in the request
        if($request->hasFile('image')){
            // get file name with extension
            // $request->file('image') - will create object of UploadedFile
            // getClientOriginalName() - a method of UploadedFile object
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            // get just file name
            // pathinfo() is a php built-in function.
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            // get just extension
            $fileExt = pathinfo($fileNameWithExt, PATHINFO_EXTENSION);

            // file name to store
            $fileNameToStore = $fileName.'_'.date("y-m-d-his").'.'.$fileExt;

            // Upload the file
            // storeAs('path_to_store',file_name)
            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else{
            $fileNameToStore = "noimage.jpg";
        }

        //create a new record and store
        $post = new Post;

        //Rule:
        //$request->input('parameter_name_of_<input>')
        //...in this case parameter is 'title'
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
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

        if($request->hasFile('image')){
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = pathinfo($fileNameWithExt, PATHINFO_EXTENSION);

            $fileNameToStore = $fileName.'_'.date("y-m-d-his").'.'.$fileExt;

            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        //only update cover_image if there is file present in the request
        if($request->hasFile('image'))
        {
            //to delete the old/current image
            if($post->cover_image != "noimage.jpg")
                Storage::delete('public/cover_images/'.$post->cover_image);
            
            //replace with new one
            $post->cover_image = $fileNameToStore;
        }
        //For deleting current image 
        elseif($request->input('deleteImage')=="true")
        {
            Storage::delete('public/cover_images/'.$post->cover_image);
            $post->cover_image = 'noimage.jpg';
        }    

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
        //Check for correct user to delete
        if (auth()->user()->id == $post->user_id)
        {
            //delete image from file storage
            if($post->cover_image != 'noimage.jpg')
                Storage::delete('public/cover_images/'.$post->cover_image);

            $post->delete();
            return redirect('/posts')->with('success','Blog Deleted');
        }
        else{
            return redirect("/posts")->with('err',"Cannot delete other's post");
        }
        
    }
    
}
