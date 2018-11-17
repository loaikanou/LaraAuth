<?php

namespace App;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'active', 'activation_token', 'api_token', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token', 'has_token', 'api_token'
    ];

    // nothing guarded - mass assigment allowed
    protected $guarded = [];

    // cast read_at as datetime
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['avatar_url'];

    public function setUsernameAttribute($name)
    {
        $this->attributes['username'] = str_slug($name, ''); //strtolower($name);
    }

//    public function setAvatarAttribute()
//    {
//        return 'uploads/avatars/'.$this->id.'/'.$this->name;
//    }

    public function getAvatarUrlAttribute()
    {
        return 'uploads/avatars/'.$this->id.'/avatar.png';
    }


    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
