@extends('layouts.master')

@section('title')
	Friends list
@endsection

@section('content')

<div class="centered">

	<h3>@include('includes.error-messages')</h3>

<h1>Friends of {{ $user->name }}</h1>

<!-- if friends list is empty -->
@if (!$friends->count())
		@if (Auth::user() == $user)
			<p>You don't have any friends yet.</p>
		@else
			<p>{{ $user->name }} doesn't have any friends yet.</p>
			<a href="{{ route('add-friend', ['username' => $user->name, 'id' => $user->id]) }}">
				<p>Send them a friend request?</p></a>
		@endif

@else
	<!-- loop through all of the users friends -->
		<div class="user-list-container">
			<div class="user-list">		

			@foreach ($friends as $friend)
				<a href="{{ route('profile', ['username' => $friend->name, 'id' => $friend->id]) }}">
					<img src="/uploads/avatars/{{ $friend->profile_img }}">
						<p>{{ $friend->name }} {{ $friend->last_name }}</br>
						{{ $friend->email }}</br>
						{{ $friend->age }} years old</p>	
				</a>
			
			<div class="accept-decline">
				<form action="{{ route('remove-friend', ['id' => $friend->id]) }}" method="post">
					<input type="submit" class="button" value="Remove">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			</div><!-- end of .accept-decline-->	

			@endforeach

			</div> <!-- end of .user-list-->
		</div> <!-- end of .user-list-container -->
@endif
<hr>

	<!-- show friend requests if current user is on it's own friends page -->
	@if(Auth::user() == $user)

		<h3>Friend requests waiting for your reply</h3>
		@if (!$friend_requests->count())
			<p>You have no pending friend requests.</p>
		@else
				<!-- loop through pending friend requests -->
			@foreach ($friend_requests as $request_owner)

				<div class="user-list-container">
					<div class="user-list">
						<a href="{{ route('profile', ['username' => $request_owner->name, 
													'id' => $request_owner->id]) }}">

							<img src="/uploads/avatars/{{ $request_owner->profile_img }}">
								<p>{{ $request_owner->name }} {{ $request_owner->last_name }}</br>
								{{ $request_owner->email }}</br>
								{{ $request_owner->age }} years old</p>	
						</a>

						<div class="accept-decline">
							<a href="{{ route('accept-friend', ['id' => $request_owner->id]) }}" class="button success">Accept</a>
							
							
						</div><!-- end of .accept-decline-->
			
					</div> <!-- end of .user-list-->
				</div> <!-- end of .user-list-container -->

			@endforeach
		@endif
		
	@endif
<br>
<a href="{{ route('profile', ['username' => $user->name, 'id' => $user->id]) }}">Go back to profile page.</a>
</div> <!-- end of .centered -->

@endsection