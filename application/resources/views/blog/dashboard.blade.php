@extends('layouts.master')
<script type='text/javascript'>
function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}
</script>


@section('title')
	Dashboard
@endsection

@section('content')

<div class="centered">

<section class="new-post">
		<h3>Make a new post</h3>
	@include('includes.error-messages')
			<!-- form for making new posts -->
		{!! Form::open(array('method'=>'POST', 'files'=> true, 'action' => 'PostController@new_post')) !!}
                <p>{!! Form::textarea('text', null, array('placeholder' => 'What are your thoughts?')); !!}</p>
                <p>{!! Form::file('image'); !!}</p>
                <p>{!! Form::submit('Post it', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
</section> <!-- end of .new-post -->

<hr>

<section class="posts">
<h3>Other people's thoughts</h3>

<!-- Loop through all posts -->
@foreach($posts as $post)

<article class="post" data-postid="{{ $post->id }}">

	@if($post->post_img != null)
		<img src="/uploads/posts/{{ $post->post_img }}">
	@endif
		<p>{{ $post->body }}</p>

	<div class="info">
		<a href="{{ route('profile', ['username' => $post->user->name, 'id' => $post->user->id]) }}" title="Go to profile page">
		<p>Posted by <b>{{ $post->user->name . ' ' . $post->user->last_name }}</b> at {{ $post->created_at }}</p>
		</a>
	</div>
	<hr>


<!--  Form to edit posts, only displays after edit button is clicked -->
<div id="edit-post{{$post->id}}" style="display:none">
	<hr>
	<h2>Edit post</h2>

	@if($post->post_img != null)
		<a href="{{ route('delete-image', ['id' => $post->id]) }}" title="Remove image">
			<button class="delete" id="delete-img"></button>
		</a>
		<img src="/uploads/posts/{{ $post->post_img }}">
	@endif

        {!! Form::open(array('method'=>'POST', 'files'=> true, 'action' => 'PostController@edit_post')) !!}
                <p id="edit-form">{!! Form::textarea('body', $post->body) !!}</p>
                <p>{!! Form::file('image'); !!}</p>
                {!! Form::hidden('post_id', $post->id) !!}
                <p>{!! Form::submit('Update post') !!}</p>
                {!! Form::close() !!}
    <p><button class="cancel" data-id="{{ $post->id }}">Cancel</button></p>
</div> <!-- end of #edit-post -->


<!-- Section that deals with like/dislikes and edit/delete post if the post author is logged in -->
<div class="interaction">
	@if (Auth::user() == $post->user)
		<button  class="edit" data-id="{{ $post->id }}">Edit</button>
		<a href="{{ route('delete-post', ['id' => $post->id]) }}" Onclick="ConfirmDelete()">
			<button class="delete">Delete</button></a>
	@else  	
			 <a href="#" class="like like-dislike">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a> |
             <a href="#" class="dislike like-dislike">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'  }}</a>
			
	@endif

	<div class="like-ratio">	
			@for ($i = 0; $i < $post->likes->count(); $i++)	
			@endfor
			<p>Likes: {{ $i }} </p>
	</div> <!-- end of .like-ratio -->
</div> <!-- end of .interaction -->

<hr/>

<!-- list upp all replies -->
	<p>Replies: {{ $post->replies->count() }}</p>

		@foreach($post->replies as $reply)
			<div class="reply-list">

				<a href="{{ route('profile', ['username' => $reply->user->name, 'id' => $reply->user->id]) }}">
					<img src="/uploads/avatars/{{ $reply->user->profile_img }}">
					<p><i>{{ $reply->user->name }} {{ $reply->user->last_name }} said:</i></p> 
				</a>
				<p>{{ $reply->body }}</p>	

<!-- the one who wrote the comment or the post owner can decide to delete replies -->
			@if (Auth::user() == $reply->user || Auth::user() == $post->user)
				<p><a href="{{ route('delete-reply', ['id' => $reply->id, 'parent-post_id' => $post->id]) }}" Onclick="ConfirmDelete()" class="delete button" id="delete-reply">Delete</a></p>
			
			@endif
					
	</div> <!-- end of .user-list -->
		@endforeach

</article> <!-- end of .post -->


	<div class="replies">
			<!-- form for making replies -->
			{!! Form::open(array('method'=>'POST', 'action' => 'PostController@post_reply')) !!}
                <p>{!! Form::textarea('reply-text', null, array('placeholder' => 'Post a reply')); !!}</p>
                <p>{!! Form::submit('Reply', array('class' => 'button')); !!}</p>
                {!! Form::hidden('post_id', $post->id) !!}
               {!! Form::close() !!}

	</div> <!-- end of .replies -->


@endforeach

</section> <!-- end of .posts -->
</div> <!-- end of .centered -->

<script>
var token = '{{ Session::token() }}';
var urlLike = "{{ route('like') }}";
</script>

@endsection