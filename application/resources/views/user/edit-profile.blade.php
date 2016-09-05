@extends('layouts.master')

@section('title')
	Edit profile
@endsection

@section('content')
<h1>Edit profile</h1>


@include('includes.error-messages')

    <div class="centered">
<div class="input-form">

    <?php $user = Auth::user(); ?>

    <img class="user-img" src="/uploads/avatars/{{ $user->profile_img }}">

                {!! Form::open(array('method'=>'POST', 'files'=>true, 'action' => 'UserController@update_profile')) !!}
                <p>{!! Form::text('name', null, array('placeholder' => $user->name)); !!}</p>
                <p>{!! Form::text('last_name', null, array('placeholder' => $user->last_name)); !!}</p>
                <p>{!! Form::text('age', null, array('placeholder' => $user->age)); !!}</p>
                <p>{!! Form::text('email', null, array('placeholder' => $user->email)); !!}</p>
                <p>{!! Form::password('password', array('placeholder' => 'Password')); !!}</p>
                <p>{!! Form::password('confirm_password', array('placeholder' => 'Confirm password')); !!}</p>
                <p>{!! Form::file('image'); !!}</p>
                <p>{!! Form::submit('Update profile', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
</div>

	</div>



@endsection