@extends('layouts.master')
<script type="text/javascript">
function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}
</script>

@section('title')
	Webbshop
@endsection

@section('content')

@include('includes.error-messages')

<div class="product-group">
<ul>
@foreach($products as $product)
<div class="products">

	
		<img class="product-img" src="/uploads/products/{{ $product->image }}">
		<li><h2>{{$product->name}}</h2>
		<p>{{$product->description}}</p>
		<p>{{$product->price}} kr</p>
		@if(Auth::check() && Auth::user()->isAdmin())
		<a href="{{ route('add-to-cart', ['id' => $product->id]) }}"><div class="button add">Add to cart</div></a>
		<a href="{{ route('edit-product', ['id' => $product->id]) }}"><div class="button edit">Edit</div></a>
		<a href="{{ route('delete-product', ['id' => $product->id]) }}"><div class="button delete" Onclick="ConfirmDelete()">Delete</div></a>
		@else
		<a href="{{ route('add-to-cart', ['id' => $product->id]) }}"><div class="button add">Add to cart</div></a>
		@endif
	</li>
	</div>
@endforeach
</ul>
</div>

@if(Auth::check() && Auth::user()->isAdmin())
<div class="admin">
	<h2>Admin interactions</h2>
<a href="{{ route('insert-product') }}"><p class="button success">Add a new product</p></a>
</div>
@endif


@endsection