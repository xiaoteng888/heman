<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
    	return view('sessions.create');
    }

    public function store(Request $request)
    {
       $user = $this->validate($request,[
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);
       if(Auth::attempt($user,$request->has('remember'))){
           session()->flash('success','欢迎回来!');
           return redirect()->route('users.show',[Auth::user()]);
       }else{
           session()->flash('danger','账号或密码错误');
           return redirect()->back()->withInput();
       }
    }

    public function destroy()
    {
    	Auth::logout();
    	session()->flash('success','您已经成功退出');
    	return redirect('login');
    }
}
