<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function create()
    {
    	return view('users.create');
    }

    public function index()
    {
         return view('users.index');
    }

    public function show(User $user)
    {
         return view('users.show',['user'=>$user]);
    }

    public function store(Request $request)
    {
    	 $this->validate($request,[
              'name' => 'required|unique:users|max:50',
              'email' => 'required|unique:users|max:255',
              'password' => 'required|confirmed|min:6'
    	 ]);
    	 $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => bcrypt($request->password),
    	 ]);
    	 session()->flash('success','欢迎注册成功！');
         return redirect()->route('users.show',[$user]);
    }

    public function edit()
    {
         return view('users.edit');
    }

    public function update()
    {
         return view('users.update');
    }

    public function destroy()
    {
         return view('users.destroy');
    }
}
