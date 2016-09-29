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
                <p>{!! Form::text('name', '', array('placeholder' => 'Name')); !!}</p>
                <p>{!! Form::text('last_name', '', array('placeholder' => 'Last name')); !!}</p>
                <p>{!! Form::text('age',  '', array('placeholder' => 'Age')); !!}</p>
                <p>{!! Form::text('email', '', array('placeholder' => 'Email')); !!}</p>
                <p>{!! Form::password('password', array('placeholder' => 'Password')); !!}</p>
                <p>{!! Form::submit('Sign up', array('class' => 'button')); !!}</p>
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                {!! Form::close() !!}
                
    </div>  <!-- end of .input-form -->    
        <p>Are you already a member? Feel free to <a href="{{ route('signin') }}"><b>sign in.</b></a></p>
	</div> <!-- end of .centered -->
@endsection