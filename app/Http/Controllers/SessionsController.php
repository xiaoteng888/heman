<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest',[
             'only' => ['create']
      ]);  
    }

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
          if(Auth::user()->activated){
            session()->flash('success','欢迎回来!');
            $fallback = route('users.show',[Auth::user()]);
            return redirect()->intended($fallback);
          }else{
            session()->flash('warning','你的账号未激活,请检查邮箱中的注册邮件进行激活!');
            return redirect('/');
          }
           
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
