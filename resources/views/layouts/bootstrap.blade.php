<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">
	
	<!-- Icons -->
	<link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet">
	<link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet">
	<link href="{{asset('css/faw/css/all.css')}}" rel="stylesheet">
	
	<!-- Theme CSS -->
	<link type="text/css" href="{{asset('css/dashboard.css')}}" rel="stylesheet">
	<link type="text/css" href="{{asset('css/argon-design-system.min.css')}}" rel="stylesheet">
	@livewireStyles
	<title>Document</title>
</head>
<body>
	@include('layouts.components.navbar')
	<div class="container pt-4 g-0">

		@include('layouts.components.menu')

		@auth
		{{$slot}}
		@else
		@yield('content')
		@endauth
	</div>
	
	<!-- Core -->
	<script src="{{asset('js/core/jquery.min.js')}}"></script>
	<script src="{{asset('js/core/popper.min.js')}}"></script>
	<script src="{{asset('js/core/bootstrap.min.js')}}"></script>
	
	<!-- Plugins -->
	<script src="{{asset('js/plugins/datetimepicker.js')}}" type="text/javascript"></script>
	<script src="{{asset('js/plugins/bootstrap-datepicker.min.js')}}"></script>
	
	<!-- Theme JS -->
	<script src="{{asset('js/argon-design-system.min.js')}}"></script>

	@livewireScripts
</body>
</html>