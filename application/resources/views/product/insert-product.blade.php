@extends('layouts.master')

@section('title')
	Add new product
@endsection

@section('content')
<h1>Add new product</h1>
	
@include('includes.error-messages')

    <div class="centered">
<div class="input-form">

                {!! Form::open(array('method'=>'POST', 'files'=>true, 'action' => 'ProductController@add_new_product')) !!}
                <p>{!! Form::text('name', null, array('placeholder' => 'Name')); !!}</p>
                <p>{!! Form::text('description', null, array('placeholder' => 'Description')); !!}</p>
                <p>{!! Form::text('price', null, array('placeholder' => 'Price')); !!}</p>
                <p>{!! Form::file('image'); !!}</p>
                <p>{!! Form::submit('Add product', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
</div>

	</div>



@endsection