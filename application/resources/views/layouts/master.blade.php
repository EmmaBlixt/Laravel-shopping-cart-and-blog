<!DOCTYPE html>
<html>
<head>
	<link href='https://fonts.googleapis.com/css?family=Raleway|Poiret+One|Josefin+Sans' rel='stylesheet' type='text/css'>
	<meta charset="UTF8">
	<title>
		@yield('title')
	</title>
	{!! Html::style('css/main.css') !!}
	@yield('styles')
</head>

<body>
	@include('includes.header')
	<div class="main">
	 	@yield('content')
	 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	 	
	 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="{{ URL::to('js/app.js')}}"></script>
	</div>
</body>
</html>