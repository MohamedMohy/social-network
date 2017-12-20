<?php
namespace App;
use Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;




class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasMediaTrait;
    use Friendable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password', 'bdate', 'gender','nname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function registerMediaConversions()
    {
        $this->addMediaConversion('icon')
            ->setManipulations(['w' => 300, 'h' => 250])
            ->performOnCollections('photos');
    }

}
