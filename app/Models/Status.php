<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{  
    protected $fillable = ['content'];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function feed()
    {
    	$userids = User::get()->pluck('id')->toArray();
        //$userids = implode(',', $userids);  
    	return $this->whereIn('user_id',$userids)->orderBy('created_at','desc')->select();
    }
}
