@extends('layouts.app')
@section('activeBlogs','active')


@section('moon')
    <h1>{{$post->title}}</h1>
    <div>
        <p>{!!$post->body!!}</p>
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by <b>{{$post->user->name}}</b></small>
    <hr>
    <a href="/posts" class="btn btn-secondary" style='float:left; margin-right:20px'>Go Back</a>
    
    <!--Only authenticated user can see Edit, Delete button-->
    @auth
        {{--or @if(Auth::user()->id == $post->user_id)--}}
        @if(auth()->user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary" style='float:left; margin-right:20px'>Edit This Post</a>
            {{Form::open(['action'=>['PostsController@destroy',$post->id]])}}
                {{Form::submit('Delete',['class'=>'btn btn-danger','onclick'=>"return confirm('Do you really want to delete this post?');"])}}
                {{Form::hidden('_method',"DELETE")}}
            {{Form::close()}}
        @endif
    @endauth
        
        
@endsection