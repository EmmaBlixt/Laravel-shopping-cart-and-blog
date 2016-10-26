<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class FriendController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    /*
|--------------------------------------------------------------------------
| Get the list of friends
|--------------------------------------------------------------------------
|
| Lists up all of the users friends & friend requests
|
*/


    public function get_friends_list($username, $id) {
      $user = User::find($id);
      $friends = $user->friends();
      $friend_requests = Auth::user()->friend_requests();
      $sent_requests = Auth::user()->pending_friend_requests();
      
      return view('user.friends-list', ['user' => $user, 
                                        'friends' => $friends, 
                                        'friend_requests' => $friend_requests,
                                        'sent_requests' => $sent_requests]);
    }

/*
|--------------------------------------------------------------------------
| Send friend request
|--------------------------------------------------------------------------
*/

  public function add_friend($username, $id) {
      $user = User::find($id);
      $message = "This user could not be found.";

        // if user can't be found, redirect to the index page with error message
      if (!$user) {
        return redirect()
          ->route('index')
          ->with((['message' => $message]));
      }

        // check if user already have a pending friend request
      if (Auth::user()->has_friend_request_pending($user) || $user->
          has_friend_request_pending(Auth::user())) {

        $message = "You have already sent a friend request to $user->name.";

            return redirect()
              ->route('profile', ['username' => $user->name, 'id' => $user->id])
              ->with((['message' => $message]));
      }

        // check if user is already friends with the other user
      if (Auth::user()->is_friends_with($user)) {
        
        $message = "You're already friends with $user->name.";

        return redirect()
          ->route('profile', ['username' => $user->name, 'id' => $user->id])
          ->with((['message' => $message]));
      }

        // successfully send a friend request
      Auth::user()->add_friend($user);
      $message = "Friend request sent.";

      return redirect()
        ->route('profile', ['username' => $user->name, 'id' => $user->id])
        ->with((['message' => $message]));

  }

/*
|--------------------------------------------------------------------------
| Accept friend request
|--------------------------------------------------------------------------
*/
  public function accept_friend($id){
      $user = User::find($id);
      $message = "User could not be found";

        // if user is not found, redirect to index
      if (!$user) {
        return redirect()
        ->route('index')
        ->with((['message' => $message]));
      }

        // if the other person hasn't added us, redirect to the index
      if (!Auth::user()->has_recieved_friend_requests($user)) {
        return redirect()->route('index');
      }


        // accepts the friend request
      Auth::user()->accept_friend_request($user);
      $message = "Friend request accepted!";

      return redirect()->route('profile', ['username' => Auth::user()->name, 'id' => Auth::user()->id])
        ->with((['message' => $message]));
  }


/*
|--------------------------------------------------------------------------
| Remove friend
|--------------------------------------------------------------------------
*/

  public function post_remove_friend($id) {
     $user = User::find($id);

  // if current user is not friends with the other user, redirect back
      if (!Auth::user()->is_friends_with($user)) {
        return redirect()->back();
      }

      $message = "Friend removed.";
      Auth::user()->delete_friend($user);
      return redirect()->back()->with((['message' => $message]));
  }


/*
|--------------------------------------------------------------------------
| Decline friend request
|--------------------------------------------------------------------------
*/
  public function post_decline_request($id) {
      $user = User::find($id);

       // if user is not found, redirect to index
      if (!$user) {
        return redirect()
        ->route('index')
        ->with((['message' => $message]));
      }

        // if the other person hasn't added us, redirect to the index
      if (!Auth::user()->has_recieved_friend_requests($user)) {
        return redirect()->route('index');
      }

      $message = "Request declined.";
      Auth::user()->decline_request($user);
      return redirect()->back()->with((['message' => $message]));
  }

}