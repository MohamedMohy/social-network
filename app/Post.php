<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = ['body',"userid"];
    //
     public function post()
    {
        return $this->belongsTo(User::class);
    }
}
