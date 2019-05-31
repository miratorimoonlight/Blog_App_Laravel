@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif

<!--'success' is param_name of the session. It's the key linked to 'success' in store() of controller-->
@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
@if(session('err'))
    <div class="alert alert-danger">
        {{session('err')}}
    </div>
@endif
