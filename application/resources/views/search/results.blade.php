@extends('layouts.master')

@section('title')
	Find a user
@endsection

@section('content')


<h1>Looking for someone?</h1>

<h2>Search results for <i>{{ $input }}</i></h2>
<hr/>

<div class="centered">


<!-- Check if search got any results -->
@if (count($users) == 0)
	<p>Sorry, we couldn't find anyone :(</p>
@else
	<!-- loop through the results -->
@foreach($users as $user)
<div class="user-list-container">

	<div class="user-list">
		<a href="{{ route('profile', ['username' => $user->name, 'id' => $user->id]) }}">
			<img src="/uploads/avatars/{{ $user->profile_img }}">
			
				<p>{{ $user->name }} {{ $user->last_name }}</br>
				{{ $user->email }}</br>
				{{ $user->age }} years old</p>	
		</a>			
	</div> <!-- end of .user-list -->
</div>		<!-- end of .user-list-container -->

@endforeach
@endif

</div> <!-- end of .centered -->
@endsection