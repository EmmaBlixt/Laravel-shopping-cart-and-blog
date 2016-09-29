@extends('layouts.master')

@section('title')
	User profile
@endsection

@section('content')

<h1>User profile</h1>


<div class="centered">


	<h3>@include('includes.error-messages')</h3>

<table>
	<tr>
		<td>
			<img class="user-img" src="/uploads/avatars/{{ $user->profile_img }}">
		</td>

	<td>
		<p>Name: {{ $user->name }} {{ $user->last_name }}</p>
		<p>Email: {{ $user->email }}</p>
		<p>Age: {{ $user->age }}</p>
		<p>Has {{ $user->friends()->count() }} 
				<!-- change output depending on the ammount of friends -->
			@if($user->friends()->count() != 1)friends
			@else friend
			@endif 
		</p>

		@if (Auth::user() == $user)
			<p>
				<a href="{{ route('edit-profile') }}" class="button">Edit profile</a>
			</p>

		@elseif (Auth::user()->is_friends_with($user))
		<form action="{{ route('remove-friend', ['id' => $user->id]) }}" method="post">
			<input type="submit" class="button" value="Remove friend">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		</form>

		@else
		<p>
			<a href="{{ route('add-friend', ['username' => $user->name,'id' => $user->id]) }}" class="button">Add friend</a>
		</p>
		@endif

		</td>
	</tr>

</table>
<hr>
 <!-- if user has no friends, hide friends list from other users -->
@if (!$user->friends()->count())

	<p>This user has no friends yet.</p>

@else

	<h3>Others who are friends with {{ $user->name }}:</h3>

<table>
	<td>
		<tr>

			<ul> 
				<!-- loop through the users friends -->
				@foreach ( $user->friends() as $friend )
				<div class="user-list-container">
					<div class="user-list">
						<a href="{{ route('profile', ['username' => $friend->name, 'id' => $friend->id]) }}">

							<img src="/uploads/avatars/{{ $friend->profile_img }}">
								<p>{{ $friend->name }} {{ $friend->last_name }}</br>
								{{ $friend->email }}</br>
								{{ $friend->age }} years old</p>	
						</a>
					</div> <!-- end of .user-list-->
				</div> <!-- end of .user-list-container -->
				@endforeach
				
			</ul>
			<a href="{{ route('friends', ['name' => $user->name, 'id' => $user->id]) }}"><h3>See all friends</h3></a>
			
		</tr>
	</td>
</table>
@endif
</div> <!-- end of .centered -->
@endsection