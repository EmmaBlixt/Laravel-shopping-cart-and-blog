<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $posts = Post::orderBy('created_at', 'desc')->get();

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

     $this->validate($request, [
      'text' => 'required|max:1000'
      ]);

      $post = new Post([
            'body' => $request->input('text')
            ]);

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
      'body' => 'required'
      ]);

    $post = Post::find($request['postId']);
    // check if logged in user is post author
    if(Auth::user() != $post->user) {
      return redirect()->back();
    }
    else

$post->body = $request['body'];

    
    $post->body = $request['body'];
    $post->update();

       return response()->json(['new_body' => $post->body], 200);
     
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
    else

    $post->delete();
    return redirect()->route('dashboard')->with(['message' => 'Post deleted!']);
  
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


}