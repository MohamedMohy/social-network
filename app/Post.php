<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = ['body',"user_id"];
    //
     public function post()
    {
        return $this->belongsTo(User::class);
    }
}
