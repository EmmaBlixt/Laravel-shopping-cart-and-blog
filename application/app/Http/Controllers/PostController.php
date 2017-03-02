<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\User;
use App\Post;
use App\Like;
use Auth;

class PostController extends Controller
{
    /*
|--------------------------------------------------------------------------
| Get routes
|--------------------------------------------------------------------------
|
| Redirect to signin/singup, edit profile and logout pages
|
*/
    public function get_dashboard() {   

        $posts = Post::where('parent_id',  0)->orderBy('created_at', 'desc')->get();
    
    return view('blog.dashboard', [
      'posts' => $posts
      ]);
    }
    /*
|--------------------------------------------------------------------------
| New post
|--------------------------------------------------------------------------
|
| Allows users to make posts, provides validation
|
*/
  public function new_post(Request $request) {
    $user = Auth::user();

     $this->validate($request, [
      'text' => 'required|max:1000'
        ]);

      $post = new Post([
            'body' => $request->input('text')
            ]);

    $file = array('image' => Input::file('image'));

// check if image was uploaded
if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    
    if($request->user()->posts()->save($post)){
      $message = "Post uploaded! (:";
     }
    return redirect()->route('dashboard')->with(['message' => $message]);
}
else


      $destinationPath = 'uploads/posts'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = $user->name . Post::all()->count() . '.' . $extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

     $post->post_img = $fileName;

    $message = "An error occured";
     // if post is successfully uploaded, print message & redirect
     if($request->user()->posts()->save($post)){
      $message = "Post uploaded! (:";
     }
    return redirect()->route('dashboard')->with(['message' => $message]);
  }
/*
|--------------------------------------------------------------------------
| Edit Post
|--------------------------------------------------------------------------
|
| Allows the posts' creator to edit the post
|
*/
 public function edit_post(Request $request) {
    $this->validate($request, [
      'body' => 'required|max:1000'
      ]);

    $post = Post::find($request['post_id']);

    // check if logged in user is post author
    if(Auth::user() != $post->user) {
      return redirect()->back();
    }
    else

    $post->body = $request['body']; 
    $file = array('image' => Input::file('image'));
    $message = "An error occurred :(";

      // check if image was uploaded
    if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {

       if($post->update()){
      $message = "Post updated! (:";
     }
    return redirect()->route('dashboard')->with(['message' => $message]);
      }

    else
      $destinationPath = 'uploads/posts'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = $post->id . '.' . $extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      
    $post->post_img = $fileName;
    
     if($post->update()){
      $message = "Post updated! (:";
     }
    return redirect()->route('dashboard')->with(['message' => $message]);
     
  }
/*
|--------------------------------------------------------------------------
| Delete Post
|--------------------------------------------------------------------------
|
| Allows the posts' creator to delete the post
|
*/
  public function delete_post($id){

    $post = Post::find($id);
  // check if logged in user is post author
    if(Auth::user() != $post->user) {
      return redirect()->back();
    }

    // fetch all replies and likes related to the post
    $replies = Post::where('parent_id', $id)->get();
    $likes = Like::where('post_id', $id)->get();
    unlink('uploads/posts/'.$post->post_img);
    $post->delete();

    // delete all replies that belong to the deleted post
    foreach ($replies as $reply) {  
    $reply->delete();
    }

    // delete all replies that belong to the deleted post
    foreach ($likes as $like) {  
    $like->delete();
    }

    return redirect()->route('dashboard')->with(['message' => 'Post deleted!']);
  
  }

/*
|--------------------------------------------------------------------------
| Delete Image
|--------------------------------------------------------------------------
|
| Allows the posts' creator to remove an image from a post
|
*/
  public function delete_image($id){

    $post = Post::find($id);
  // check if logged in user is post author
    if(Auth::user() != $post->user) {
      return redirect()->back();
    }

    unlink('uploads/posts/'.$post->post_img);
    $post->post_img = null;
    $message = "An error occurred";

      if($post->update()){
      $message = "Image removed";
     }
    
    return redirect()->route('dashboard')->with(['message' => $message]);
  
  }

/*
|--------------------------------------------------------------------------
| Like Post
|--------------------------------------------------------------------------
|
| Handle post likes and dislikes
|
*/
    public function like_post(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        //if post can't be fetched, do nothing
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
          // is post is in like/dislike table
        if ($like) {
            $already_like = $like->like;
            $update = true;
              // if post is already liked, remove like status
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else { 
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
         // check if post is already in like table, updates if yes, save if not
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }

/*
|--------------------------------------------------------------------------
| Reply
|--------------------------------------------------------------------------
|
| Allows users to reply to posts, provides validation
|
*/
  public function post_reply(Request $request) {
     $this->validate($request, [
      'reply-text' => 'required|max:1000'
      ]);


      $post = new Post([
            'body' => $request->input('reply-text'),
            'parent_id' => $request->input('post_id')
            ]);

      $message = "An error occurred";

     // if reply is successfully uploaded, print message & redirect

     if($request->user()->posts()->save($post)){
      $message = "Reply uploaded! (:";
     }
    return redirect()->route('dashboard')->with(['message' => $message]);
  }


  public function get_replies() {

  }

  /*
|--------------------------------------------------------------------------
| Delete Reply
|--------------------------------------------------------------------------
|
| Allows the posts' creator to delete the post
|
*/
  public function delete_reply($id, $parent_post_id){

    $parent_post = Post::find($parent_post_id);
    $post = Post::find($id);

  // check if logged in user is post author
    if(Auth::user() == $post->user OR Auth::user() == $parent_post->user) {
       $post->delete();
    return redirect()->route('dashboard')->with(['message' => 'Reply removed']);
    }

    return redirect()->back();
  
  }

}