@extends('layouts.app')

@section('moon')
    <h1>Edit Post</h1>
    
    <!--Rule:           'action' => [controller_function, parameterOfThatFunc]      -->
    {{ Form::open(array('action' => ['PostsController@update',$post->id], 'enctype'=>'multipart/form-data')) }}
        <div class="form-group">

            <!--same as <label for='title'>Title</label>-->
            {{Form::label('title','Title')}}

            <!--will create input of type='text', name=id='title', another attr like class and placeholder-->
            {{Form::text('title',$post->title,['class'=>'form-control','placeholder'=>'Title'])}}
        </div>
        <br>
        <div class="form-group">
            {{Form::label('body','Content')}}
            {{Form::textarea('body',$post->body,['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Write your content...'])}}
        </div>
        <!-- For file input -->
        <div class="form-group">
            {{-- <input type='file' name='image' --}}
            {{Form::file('image')}}
            <br><br>
            
            <!--Handle Cover Image: Add/Delete-->
            @if($post->cover_image!='noimage.jpg')
                <label>Current Image: </label>
                <img src="/storage/cover_images/{{$post->cover_image}}" style="height:100px; width:auto;">
                <br>
                <label>Delete Current Image? {{Form::checkbox('deleteImage', 'true',['class'=>'custom-control-input'])}} </label>
            @endif
        </div>
        {{-- By default Laravel creates Post method. So we need to do this below --}}
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Done',['class'=>'btn btn-primary'])}}
    {{ Form::close() }}

@endsection