@extends('layouts.master')

@section('title')
	User profile
@endsection

@section('content')
<h1>User profile</h1>

<table>
<tr><td>
	
	<img class="user-img" src="/uploads/avatars/{{ $user->profile_img }}">
	
	</td>
	<td><p>Name: {{ $user->name }} {{ $user->last_name }}</p>
	<p>Email: {{ $user->email }}</p>
	<p>Age: {{ $user->age }}</p>
<p><a href="{{ route('edit-profile') }}" class="button">Edit profile</a></p>
</td>

</tr>

</table>



@endsection