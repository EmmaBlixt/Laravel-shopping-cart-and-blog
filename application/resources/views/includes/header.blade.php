<header>

<nav>
	<ul>
		<li><a href="{{ route('index') }}">Home</a></li>
		<li><a href="{{ route('dashboard') }}">Blog</a></li>
		<a href=""></a>
<div class="nav-right">
	

	@if(Auth::check())
			<li><a href="{{ route('profile') }}">Welcome {{Auth::user()->name}}</a></li>
	@endif
	
	<li>
	<a href="{{ route('shopping-cart') }}">
		<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
	<span class="badge">{{ Session::has('cart') ? Session::get('cart')->total_quantity : '' }}</span>
	</a></li>

<div class="dropdown-nav">
	<p>User management</p>
<ul class="dropdown-nav-content">

	@if(Auth::check())
			<li><a href="{{ route('profile') }}">Profile</a></li>
			<li><a href="{{ route('logout') }}">Log out</a></li>
			<li><a href="{{ route('shopping-cart') }}">Shopping cart</li></a>
		@else
	<li><a href="{{ route('signin') }}">Sign in</a></li>
	<li><a href="{{ route('signup') }}">Sign up</a></li>
	<li><a href="{{ route('shopping-cart') }}">Shopping cart</a></li>
	@endif


</ul>
</div>
</div>
</ul>

</nav>
</header>