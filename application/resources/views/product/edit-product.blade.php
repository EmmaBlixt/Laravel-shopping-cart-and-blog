@extends('layouts.master')

@section('title')
	Edit product
@endsection

@section('content')
<h1>Edit product</h1>

@include('includes.error-messages')

    <div class="centered">
<div class="input-form">

<img class="product-img" src="/uploads/products/{{ $product->image }}">

                {!! Form::open(array('method'=>'POST', 'files'=>true, 'action' => 'ProductController@post_edit_product')) !!}
                <p>{!! Form::text('name', null, array('placeholder' => $product->name)); !!}</p>
                <p>{!! Form::text('description', null, array('placeholder' => $product->description)); !!}</p>
                <p>{!! Form::text('price', null, array('placeholder' => $product->price)); !!}</p>
                <p>{!! Form::file('image'); !!}</p>
                {!! Form::hidden('id', $product->id) !!}
                <p>{!! Form::submit('Edit product', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
</div>

	</div>



@endsection