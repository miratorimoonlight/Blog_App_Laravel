@extends('layouts.app')
{{-- @section('activeCreatePost','active') --}}
@section('moon')
    <h1>Create New Post</h1>
    {{ Form::open(array('action' => 'PostsController@store', 'method' =>'POST')) }}
        <div class="form-group">

            <!--same as <label for='title'>Title</label>-->
            {{Form::label('title','Title')}}

            <!--will create input of type='text', name=id='title', another attr like class and placeholder-->
            {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}
        </div>
        <br>
        <div class="form-group">
            {{Form::label('body','Content')}}
            {{Form::textarea('body','',['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Write your content...'])}}
        </div>
        {{Form::submit('Done',['class'=>'btn btn-primary'])}} 
    {{ Form::close() }}

@endsection