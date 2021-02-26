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
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
	@livewireStyles
	
	<!-- Fonts -->
	<link href="{{asset('faw/css/all.css')}}" rel="stylesheet">
	
	<style type="text/css">
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
</head>
<body>
	
	{{-- sidebar --}}
	@include('layouts.components.topnav')
	
	{{-- main content --}}
	@yield('content')
	
	
	<!-- Scripts -->
	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
	<script src="{{asset('js/jquery.js')}}"></script>
	<script src="{{asset('semantic/semantic.js')}}"></script>
	<script src="{{asset('js/script.js')}}"></script>
	@livewireScripts
	
</body>
</html>