@extends('layouts.app')

@section('moon')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
    
        {{-- @if (session('status'))
            <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            You are logged in! --}}
            <div style="margin-top:30px">
                <div class="card">
                    <div class="card-body">
                        <a href="/posts/create" class="btn btn-primary" style="float:right">Create Post</a>
                        <h3 class="card-title">Your Posts</h3>
                        <br>
                        @if(count($posts)>0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                
                                @foreach ($posts as $post)
                                    <tr>
                                        <td> {{$post->title}} </td>
                                        <td><a href="/posts/{{$post->id}}/edit" class="btn btn-dark">Edit</a></td>
                                        <td>
                                            {{Form::open(['action'=>['PostsController@destroy',$post->id]])}}
                                                {{Form::submit('Delete',['class'=>'btn btn-danger','onclick'=>"return confirm('Do you really want to delete this post?');"])}}
                                                {{Form::hidden('_method',"DELETE")}}
                                            {{Form::close()}}
                                        </td>    
                                    </tr>
                                @endforeach()
                            </table>
                        @else
                            <p>You have no posts yet...</p>
                        @endif
                    </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
