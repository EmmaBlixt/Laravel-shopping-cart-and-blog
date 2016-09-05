@extends('layouts.master')
<script   src="https://code.jquery.com/jquery-3.0.0.js"   integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo="   crossorigin="anonymous"></script>

@section('title')
    Sign up
@endsection

@section('content')
<h1>Sign up</h1>


@include('includes.error-messages')

    <div class="centered">
<div class="input-form">

                {!! Form::open(array('action' => 'UserController@post_signup')) !!}
                <p>{!! Form::text('name',  null, array('placeholder' => 'Name')); !!}</p>
                <p>{!! Form::text('last_name',  null, array('placeholder' => 'Lastame')); !!}</p>
                <p>{!! Form::text('age',  null, array('placeholder' => 'Age')); !!}</p>
                <p>{!! Form::text('email', null, array('placeholder' => 'Email')); !!}</p>
                <p>{!! Form::password('password', array('placeholder' => 'Password')); !!}</p>
                <p>{!! Form::submit('Sign up', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
                <br>
</div>
             
<p>Are you already a member? Feel free to <a href="{{ route('signin') }}">sign in.</a></p>
	</div>
@endsection