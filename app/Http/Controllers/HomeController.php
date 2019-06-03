<?php

namespace Blog_Website_Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Blog_Website_Laravel\Http\Controllers\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //Request will get through this middleware() first before going any further with this controller
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //get the object of logged-in user...
        $user = auth()->user();
        return view('home')-> with('posts',$user->posts);
    }
}
