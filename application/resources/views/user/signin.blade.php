@extends('layouts.master')
<script   src="https://code.jquery.com/jquery-3.0.0.js"   integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo="   crossorigin="anonymous"></script>

@section('title')
    Sign in
@endsection

@section('content')
<h1>Sign in</h1>

@include('includes.error-messages')

    <div class="centered">
<div class="input-form">


                {!! Form::open(array('action' => 'UserController@post_signin')) !!}
                <p>{!! Form::text('email', null, array('placeholder' => 'Email')); !!}</p>
                <p>{!! Form::password('password', array('placeholder' => 'Password')); !!}</p>
                <p>{!! Form::submit('Sign in', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
               
</div>

 <br>
<p>Not a member? Feel free to <a href="{{ route('signup') }}">sign up.</a></p>
</div>

	
@endsection