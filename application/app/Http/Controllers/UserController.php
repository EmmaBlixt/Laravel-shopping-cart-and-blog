<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\User;
use Auth;
use Session;
use DB;
use App\Friend;

class UserController extends Controller
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

    public function get_signup() {   
        return view('user.signup');
    }


    public function get_signin() {   
        return view('user.signin');
    }

      public function get_profile($username, $id) {   
        $user = User::find($id);
        return view('user.profile', ['user' => $user]);
  }
    

     public function get_logout() {   
        Auth::logout();
        Session::flush();
        return redirect()->route('index');
    }

     public function edit_profile() {   
        return view('user.edit-profile');
    }


/*
|--------------------------------------------------------------------------
| Update profile
|--------------------------------------------------------------------------
|
| Allows user to update user and add a display image
| 
*/

  public function update_profile(Request $request) {

    $user = Auth::user();

    $this->validate($request, [
      'name' => 'required|alpha',
      'last_name' => 'alpha',
      'age' => 'numeric',
      'password' => 'required|min:4',
      'confirm_password' => 'required|same:password',
      'email' => 'required|email'
      ]);

    $user->name = $request->get('name');
    $user->last_name = $request->get('last_name');
    $user->email = $request->get('email');
    $user->age = $request->get('age');
    $user->password = bcrypt($request->input('password'));

    $file = array('image' => Input::file('image'));

// check if image was uploaded
if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    $user->update();
    return redirect()->route('profile', ['username' => $user->name, 'id' => $user->id]);
}
else

      $destinationPath = 'uploads/avatars'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = $user->name . $user->id . '.' . $extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      
     $user->profile_img = $fileName;
     $user->update();
    return redirect()->route('profile', ['username' => $user->name, 'id' => $user->id]);
  }



/*
|--------------------------------------------------------------------------
| Post signup
|--------------------------------------------------------------------------
|
| Allows user to make a new profile
| 
*/

    public function post_signup(Request $request) {
       $this->validate($request, [
                        'email' => 'email|required|unique:users',
                        'password' => 'required|min:4',
                        'name' => 'required|alpha',
                        'last_name' => 'alpha',
                        'age' => 'numeric'
                    ]);

            $user = new User([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'age' => $request->input('age'),
            'remember_token' => $request->input('_token')
            ]);
        $user->password = bcrypt($request->input('password'));

        $user->save();
        Auth::login($user);
        return redirect()->route('profile', ['username' => $user->name, 'id' => $user->id]);
    }
    
/*
|--------------------------------------------------------------------------
| Post signin
|--------------------------------------------------------------------------
|
| Allows user to sign in to existing profile
| 
*/

  public function post_signin(Request $request) {
       $this->validate($request, [
                        'email' => 'email|required',
                        'password' => 'required|min:4',
                    ]);

      if (Auth::attempt(['email' => $request->input('email'), 
                        'password' => $request->input('password')])) {
              $id = Auth::user()->id;
        return redirect()->route('profile', ['username' => Auth::user()->name, 'id' => Auth::user()->id]);
      }
      
      $message = "Wrong username or password!";
      return redirect()->route('signin')->with(['message' => $message]);
    }


/*
|--------------------------------------------------------------------------
| User search function
|--------------------------------------------------------------------------
|
| Allows you to find users
| 
*/

 public function get_results(Request $request) {

       $this->validate($request, [
                        'text' => 'required'
                    ]);

    $input = $request->get('text');
    $users = User::where(DB::raw("CONCAT(name, ' ', last_name, email)"),
      'LIKE', "%${input}%")->get();

    return view('search.results', ['users' => $users, 'input' => $input]);
 }


}