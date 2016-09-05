

@extends('layouts.master')

@section('title')
	Shopping cart
@endsection

@section('content')
<h1>Shopping cart</h1>

	@if(Session::has('cart'))
		<div>
			<ul>
				@foreach($products as $product)
				<div class="cart">
					<p>{{$product['item']['name']}}</p>
					<button class="button success">{{$product['price']}} kr</button>

					<button class="button black">{{$product['quantity']}}</button>
						<div class="dropdown">
						<button onclick="myFunction()" class="dropbtn button">Change quantity</button>
							  <div id="myDropdown" class="dropdown-content">
    						<a href="{{ route('remove-from-cart', [$product['item']['id']]) }}">-</a>
    						<a href="{{ route('add-to-cart', [$product['item']['id']]) }}">+</a>
 						 	</div>
						</div>
				</div>
				@endforeach


    						<a class="button" href="{{ route('clear-cart') }}">Empty cart</a>
			</ul>
		</div>

		<div>
			<h2>Total price: {{ $total_price }} kr</h2>
			<a href="{{ route('checkout') }}" type="button" class="button success">Checkout</a>

		</div>
	@else
		<h2>There are no items in your cart.</h2>
	@endif
@endsection