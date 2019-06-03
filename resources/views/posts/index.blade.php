@extends('layouts.app')
@section('activeBlogs','active')
@section('moon')
    <h1>Posts</h1>
    @if (count($posts)>0)
        @foreach ($posts as $post)
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:100%;" src="storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                        <!-- function user() in Post.php makes it possible to do $post->user->name like below-->
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
                
            </div>
        @endforeach
        <br>

        <!--    To put pages button - pagination -->
        {{$posts->links()}}
    @else
        <p> No post found </p>    
    @endif

@endsection