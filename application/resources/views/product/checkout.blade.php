@extends('layouts.master')

@section('title')
	Checkout
@endsection

@section('content')

<h1>Checkout</h1>

<h2>Your total price: {{ $total }} kr</h2>
<div class="input-form">
    {!! Form::open(array('action' => 'ProductController@get_checkout')) !!}
                <p>{!! Form::text('name', null, array('placeholder' => 'Name')); !!}</p>
                <p>{!! Form::text('description', null, array('placeholder' => 'Description')); !!}</p>
                {!! Form::text('price', null, array('placeholder' => 'Price')); !!}
                {!! Form::submit('Submit', array('class' => 'button')); !!}
                {!! Form::close() !!}
</div>

@endsection