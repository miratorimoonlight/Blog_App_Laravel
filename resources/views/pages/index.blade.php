@extends('layouts.app')

@section('activeHome','active')
@section('hideSearch','hidden')
@section('moon')
    {{-- <h1>Welcome to my app</h1> --}}
    <div class="jumbotron">
            <div class="container text-center">
              <h1 class="display-3 ">{{$title}}</h1>
              <h4>Now you can record all your stories and share with anyone in the world.</h4>
              <hr>
              @auth
                <a class="btn btn-primary" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Logout
                </a>
              @else
                <p><a class="btn btn-primary btn-lg" href="/login" role="button">login &raquo;</a></p>
              @endauth
            </div>
          </div>
    <!--section is like initialize for var moon-->
@endsection

