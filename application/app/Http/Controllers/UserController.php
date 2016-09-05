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

      public function get_profile() {   
        $id = Auth::user()->id;
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
    bcrypt($request->input('password'));

    $file = array('image' => Input::file('image'));

// check if image was uploaded
if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    $user->update();
    return redirect()->route('profile');
}
else

      $destinationPath = 'uploads/avatars'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = $user->name . $user->id . '.' . $extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      
     $user->profile_img = $fileName;
     $user->update();
    return redirect()->route('profile');
  }



/*
|--------------------------------------------------------------------------
| Post signup/signin
|--------------------------------------------------------------------------
|
| Allows user to make a new profile or sign in on an existing one
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
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'age' => $request->input('age'),
            ]);
        $user->save();
        Auth::login($user);
        return redirect()->route('profile');
    }
    


        public function post_signin(Request $request) {
       $this->validate($request, [
                        'email' => 'email|required',
                        'password' => 'required|min:4',
                    ]);

      if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
      
        return redirect()->route('profile');
      }
      return redirect()->route('index');
    }

}