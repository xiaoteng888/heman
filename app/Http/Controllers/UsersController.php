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

    public function store()
    {
         return view('users.store');
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
