<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth',[
             'except' => ['create','show','store']
    	]);
    	$this->middleware('guest',[
             'only' => ['create']
    	]);
    }  

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
    	 Auth::login($user);
    	 session()->flash('success','欢迎注册成功！');
         return redirect()->route('users.show',[$user]);
    }

    public function edit(User $user)
    {
    	 $this->authorize('update',$user);
         return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {    
    	 $this->authorize('update',$user);
    	 $this->validate($request,[
               'name' => 'required|max:50',
               'password' => 'nullable|min:6|confirmed',
    	 ]);
    	 $data = [];
    	 $data['name'] = $request->name;    	 
    	 if($request->password){
               $data['password'] = bcrypt($data['password']);     
    	 }
    	 
    	 $user->update($data);
    	 session()->flash('success','更新成功！');
         return redirect()->route('users.show',$user->id);
    }

    public function destroy()
    {
         return view('users.destroy');
    }
}
