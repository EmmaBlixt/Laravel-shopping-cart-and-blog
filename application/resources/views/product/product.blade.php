@extends('layouts.master')
<script   src="https://code.jquery.com/jquery-3.0.0.js"   integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo="   crossorigin="anonymous"></script>

@section('content')

<div class="products">
<ul>

	<img class="product_img" src=".."/>
	<h2>{{ ucfirst($product) }}  </h2>

<p>{{ $product }}</p>
</ul>
</div>
	<div class="centered">
<a href="{{ route('index') }}">Home</a>

	</div>
@endsection