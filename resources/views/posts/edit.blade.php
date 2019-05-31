@extends('layouts.app')

@section('moon')
    <h1>Edit Post</h1>
    
    <!--Rule:           'action' => [controller_function, parameterOfThatFunc]      -->
    {{ Form::open(array('action' => ['PostsController@update',$post->id])) }}
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
        {{-- By default Laravel creates Post method. So we need to do this below --}}
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Done',['class'=>'btn btn-primary'])}}
    {{ Form::close() }}

@endsection