<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 'fname', 'lname', 'email', 'age', 'gender' , 'profile_pic', 'address', 'fullname',
    ];

    public function bandmember()
    {
        return $this->hasMany('App\BandMember','user_id','user_id');
    }
    public function preferences()
    {
        return $this->hasMany('App\Preference', 'user_id');
    }
    public function playlists()
    {
        return $this->hasMany('App/Playlist', 'user_id', 'user_id');
    }
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
