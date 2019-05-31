<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view("pages.index")->with(['title'=>'Welcome to my blog app!!']);
    }

    public function about()
    {
        $moon ='About us';
        return view("pages.about",compact('moon'));
    }

    public function services()
    {
        $data = array(
            'title' => 'Our Services', 
            'services'=>["Web Design", "Mobile App dev", "Web Pentesting"]
        );
        return view("pages.services",$data);
    }
}
