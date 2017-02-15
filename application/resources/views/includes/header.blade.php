<header>

<nav>
	<ul>
		<li><a href="{{ route('index') }}">Home</a></li>
		<li><a href="{{ route('dashboard') }}">Blog</a></li>
		<a href=""></a>

		<!-- form for user search function -->
	<li id="search-form">
				{!! Form::open(array('method'=>'POST', 'action' => 'UserController@get_results')) !!}
                <p>{!! Form::text('text', null, array('placeholder' => 'Find users')); !!}</p>
                <p>{!! Form::submit('Search', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
	</li>


<div class="nav-right">
	<?php
	$date = date('Y-m-d');
	?>

	<!-- Echo out the number of events this user has today-->
@if (Auth::check() && Auth::user()->events()->event_date = $date)

	<li>
		<a href="{{ route('calendar') }}" 
			title="You have {{ Auth::user()->events()->where('event_date', $date)->count() }} @if(Auth::user()->events()->where('event_date', $date)->count() == 1)event @else events @endif today!">
		☑ {{ Auth::user()->events()->where('event_date', $date)->count() }}
		</a>
	</li>
@endif


	<!-- Echo out the number of unread messages this user has -->
@if (Auth::check() && Auth::user()->unread_recieved_messages()->count())
	<li>
		<a href="{{ route('messages', ['username' => Auth::user()->name, 'id' => Auth::user()->id]) }}" 
			title="You have {{ Auth::user()->unread_recieved_messages()->count() }} unread @if(Auth::user()->unread_recieved_messages()->count() == 1)message! @else messages! @endif">
		☺ {{ Auth::user()->unread_recieved_messages()->count() }}
		</a>
	</li>
@endif


	<!-- Echo out the number of friend requests this user has -->
@if (Auth::check() && Auth::user()->friend_requests()->count())
	<li>
		<a href="{{ route('friends', ['name' => Auth::user()->name, 'id' => Auth::user()->id]) }}" 
			title="You have {{ Auth::user()->friend_requests()->count() }} friend @if(Auth::user()->friend_requests()->count() == 1)request! @else requests! @endif">
		♥ {{ Auth::user()->friend_requests()->count() }}
		</a>
	</li>
@endif

	@if(Auth::check())
			<li>
				<a href="{{ route('profile', ['username' => Auth::user()->name, 
											'id' => Auth::user()->id]) }}" title="Go to profile page">
				Welcome {{Auth::user()->name}}
				</a>
			</li>
	@endif
	
	<li>
	<a href="{{ route('shopping-cart') }}" title="Shopping cart">
		<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
	<span class="badge">{{ Session::has('cart') ? Session::get('cart')->total_quantity : '' }}</span>
	</a></li>

<div class="dropdown-nav">
		<p>User management</p>
	<ul class="dropdown-nav-content">

	@if(Auth::check())
			<li><a href="{{ route('profile', ['username' => Auth::user()->name, 'id' => Auth::user()->id]) }}">Profile</a></li>
			<li><a href="{{ route('messages', ['username' => Auth::user()->name, 'id' => Auth::user()->id]) }}" >Messages</a></li>
			<li><a href="{{ route('friends', ['name' => Auth::user()->name, 'id' => Auth::user()->id]) }}">Friends</li></a>
			<li><a href="{{ route('calendar') }}">Calendar</li></a>
			<li><a href="{{ route('shopping-cart') }}">Shopping cart</li></a>
			<li><a href="{{ route('logout') }}">Log out</a></li>
		@else
			<li><a href="{{ route('signin') }}">Sign in</a></li>
			<li><a href="{{ route('signup') }}">Sign up</a></li>
			<li><a href="{{ route('shopping-cart') }}">Shopping cart</a></li>
	@endif


	</ul> <!-- end of .dropdown-nav-content -->
</div> <!-- end of .dropdown-nav -->
</div> <!-- end of .nav-right -->
</ul>
</nav>
</header>