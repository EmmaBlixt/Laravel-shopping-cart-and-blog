<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Message;

class MessageController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    /*
|--------------------------------------------------------------------------
| Get routes
|--------------------------------------------------------------------------
|
| Redirect to signin/singup, edit profile and logout pages
|
*/

    public function get_messages() {

      $recieved_messages = Message::where('to_id', Auth::user()->id)->get();
      $sent_messages = Message::where('from_id', Auth::user()->id)->get();

      // delete old messages that have were sent three months ago
      $old_messages = Message::where('from_id', Auth::user()->id)
                      ->where('created_at', '<', date("Y-m-d",strtotime("-3 Months")))
                      ->delete();
      
      return view('user.messages', ['user' => Auth::user(),  
                                        'recieved_messages' => $recieved_messages,
                                        'sent_messages' => $sent_messages]);
    }

/*
|--------------------------------------------------------------------------
| Send messages
|--------------------------------------------------------------------------
|
| Send messages to other users
|
*/

public function send_message(Request $request) {


    $to_user = User::find($request['user_id']);

    // check if the users are friends
    if(!Auth::user()->is_friends_with($to_user)) {
      return redirect()->back();
    }
    else

        $this->validate($request, [
      'message' => 'required|max:1000'
      ]);


          $new_message = new Message([
            'message' => $request['message'],
            'to_id' => $request['user_id'],
            'from_id' => Auth::user()->id
            ]); 

            $message = "An error occured";
     // if post is successfully uploaded, print message & redirect
     if($new_message->save()){
      $message = "Message sent! (:";
     }
    return redirect()->back()->with((['message' => $message]));
  }

  




/*
|--------------------------------------------------------------------------
| Reply to messages
|--------------------------------------------------------------------------
|
| Reply to messages from other users
|
*/
 public function reply_to_message(Request $request) {
    $this->validate($request, [
      'message' => 'required|max:1000'
      ]);

    $sent_message = Message::find($request['message_id']);

    $sender = User::find($sent_message->from_id);

    // redirect back if the user aren't friends
    if(!Auth::user()->is_friends_with($sender)) {
      return redirect()->back();
    }
    else
    
    $sent_message->message = $request['message'];
    $sent_message->to_id = $sender->id;
    $sent_message->from_id = Auth::user()->id;
    $sent_message->update();

       return redirect()->route('messages', ['username' => Auth::user()->name, 'id' => Auth::user()->id])
       ->with((['message' => "Message has been sent."]));
     
  }


/*
|--------------------------------------------------------------------------
| Delete Message
|--------------------------------------------------------------------------
|
| Delete messages
|
*/
  public function delete_message($id){

    $message = Message::find($id);

    $message->delete();
    return redirect()->route('messages', ['username' => Auth::user()->name, 'id' => Auth::user()->id])
       ->with((['message' => "Message has been deleted."]));
  
  }


}