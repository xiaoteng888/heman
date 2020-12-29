<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = User::first();
        $user_id = $user->id;

        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();
        //1号用户关注所有用户
        $user->follow($follower_ids);
        //所有用户都关注1号
        foreach ($followers as $follower) {
        	$follower->follow($user_id);
        }
    }
}
