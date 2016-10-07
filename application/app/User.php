<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Auth;
use DB;

class User extends Model implements AuthenticatableContract

{

    use Authenticatable;
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



public function isAdmin() {
    return $this->admin; // this looks for an admin column in your users table
}

/*
|--------------------------------------------------------------------------
| Post functions
|--------------------------------------------------------------------------
|
| Handle posts and likes/dislikes
|
*/

    public function likes() {
        return $this->hasMany('App\Like');
    }

     public function dislikes() {
        return $this->hasMany('App\Like');
    }


    public function posts() {
        return $this->hasMany('App\Post');
    }



/*
|--------------------------------------------------------------------------
| Friend relationships
|--------------------------------------------------------------------------
|
| Deals with who's friends with who
|
*/

    public function friends_of_mine() {
        return $this->belongsToMany( 'App\User', 'friends', 'user_id', 'friend_id');
    }
        // fetch friends of this user
    public function friend_of() {
        return $this->belongsToMany( 'App\User', 'friends', 'friend_id', 'user_id');
    }

        // fetch friend requests that are accepted from both sides
    public function friends() {
        return $this->friends_of_mine()->wherePivot('accepted', true)->get()->
        merge($this->friend_of()->wherePivot('accepted', true)->get());
    }

/*
|--------------------------------------------------------------------------
| Friend requests
|--------------------------------------------------------------------------
|
| Deals with accepting and pending friend requests
|
*/

        // friend requests from other users
    public function friend_requests() {
        return $this->friends_of_mine()->wherePivot('accepted', false)->get();
    }


        // friend requests to other users
    public function pending_friend_requests() {
        return $this->friend_of()->wherePivot('accepted', false)->get();
    }


        // check if a user has a pending friend request
    public function has_friend_request_pending(User $user) {
        return (bool) $this->pending_friend_requests()->where('id', $user->id)->count();
    }


        // see if current user has pending request from other user
    public function has_recieved_friend_requests(User $user) {
        return (bool) $this->friend_requests()->where('id', $user->id)->count();
    }


        // attach logged in user to the other user
    public function add_friend(User $user) {
        $this->friend_of()->attach($user->id);
    }

        // accept pending friend requests
    public function accept_friend_request(User $user) {
        $this->friend_requests()->where('id', $user->id)->first()->pivot->
            update([
                'accepted' => true,
                ]);
    }

        // check if user is friend with a certain user
    public function is_friends_with(User $user) {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

/*
|--------------------------------------------------------------------------
| Remove friend
|--------------------------------------------------------------------------
*/
    public function delete_friend(User $user){
        $this->friend_of()->detach($user->id);
        $this->friends_of_mine()->detach($user->id);
    }



    public function decline_request(User $user) {
        $this->friend_of()->detach($user->id);
        $this->friends_of_mine()->detach($user->id);
    }


}