<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;
	protected $fillable = ['body',"user_id","privacy"];
    //
     public function post()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function registerMediaConversions()
    {
        $this->addMediaConversion('icon')
            ->setManipulations(['w' => 300, 'h' => 250])
            ->performOnCollections('photos');
    }
}
