<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth',[
             'except' => ['create','show','store','index','confirmEmail']
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
    	 $users = User::paginate(10);
         return view('users.index',compact('users'));
    }

    public function show(User $user)
    {
    	 $statuses = $user->statuses()
    	                    ->orderBy('created_at','desc')
    	                    ->paginate(10);
         return view('users.show',compact('user','statuses'));
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
    	 /*Auth::login($user);
    	 session()->flash('success','欢迎注册成功！');
         return redirect()->route('users.show',[$user]);*/
         $this->sendEmailConfirmationTo($user);
         session()->flash('success','验证邮件已发到你的注册邮箱，请注意查收');
         return redirect('/');
    }

    public function sendEmailConfirmationTo($user)
    {
    	$view = 'emails.confirm';
    	$data = compact('user');
    	$to = $user->email;
    	$subject = '感谢注册微博APP！请确认你的邮箱。';

        Mail::send($view,$data,function($msg) use ($to,$subject){
             $msg->to($to)->subject($subject);
        }); 
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activation_token = null;
        $user->activated = true;
        $user->save();

        Auth::login($user);
        session()->flash('success','激活成功!');
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

    public function destroy(User $user)
    {
    	 $this->authorize('destroy',$user);
    	 $user->delete();
    	 session()->flash('success', '成功删除用户！');
         return back();
    }
}
