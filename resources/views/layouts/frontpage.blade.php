<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{{ config('app.name', 'Raudhah Inventory') }}</title>
	<!-- Styles -->
	<link rel="stylesheet" href="{{asset('semantic/semantic.css')}}">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	@livewireStyles
	
	<!-- Fonts -->
	<link href="{{asset('faw/css/all.css')}}" rel="stylesheet">
	
	
</head>
<body>
	<div class="ui secondary pointing menu huge">
		<a href="{{url('/')}}" class="header item">
			{{config('app.name')}}
		</a>
		@auth
		<a href="{{route('dashboard.index')}}" class="item active">
			Dashboard
		</a>
		@endauth
		<div class="right menu">
			@auth
			<a class="ui item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Logout
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
				@csrf
			</form>
			@else
			<a href="{{route('login')}}" class="ui item">
				Login
			</a>
			@endauth
		</div>
	</div>
	
	<div class="ui container">
		{{$slot}}
	</div>
	
	
	<!-- Scripts -->
	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
	@livewireScripts
	<script src="{{asset('js/jquery.js')}}"></script>
	<script src="{{asset('semantic/semantic.js')}}"></script>
	<script src="{{asset('js/script.js')}}"></script>
	<script>
		$(document).ready(function(){
			window.livewire.on('selectdropdown', () => {
				$('.ui.dropdown').dropdown();
			});
			window.livewire.on('setCheckbox', () => {
				$(".ui.checkbox").checkbox();
			});
			window.livewire.on("setModal", () => {
				$("#modalSubmitReport").modal("show");
			});
		});
	</script>
</body>
</html>