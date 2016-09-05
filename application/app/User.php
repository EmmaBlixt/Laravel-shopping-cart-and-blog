<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

public function isAdmin()
{
    return $this->admin; // this looks for an admin column in your users table
}


    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function dislikes(){
        return $this->hasMany('App\Like');
    }

}
