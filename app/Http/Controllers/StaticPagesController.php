<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StaticPagesController extends Controller
{
    public function help()
    {
    	return view('static_pages/help');
    }
    public function home(Status $status)
    {   
        $feed_items = [];
        if(Auth::check()){
           $feed_items = $status->feed()->paginate(15);   
        }
    	return view('static_pages/home',compact('feed_items'));
    }
    public function about()
    {
    	return view('static_pages/about');
    }
}
