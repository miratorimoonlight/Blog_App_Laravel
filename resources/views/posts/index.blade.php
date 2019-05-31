@extends('layouts.app')
@section('activeBlogs','active')
@section('moon')
    <h1>Posts</h1>
    @if (count($posts)>0)
        @foreach ($posts as $post)
            <div class="card card-body">
                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <!-- function user() in makes it possible to do $post->user->name like below-->
                <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
            </div>
        @endforeach
        <br>

        <!--To put pages button-->
        {{$posts->links()}}
    @else
        <p> No post found </p>    
    @endif

@endsection