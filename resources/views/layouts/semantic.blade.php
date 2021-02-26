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
	<link rel="stylesheet" href="{{asset('css/dataTables.semanticui.min.css')}}">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
	@livewireStyles
	
	<!-- Fonts -->
	<link href="{{asset('faw/css/all.css')}}" rel="stylesheet">
	
	
</head>
<body>
	
	{{-- sidebar --}}
	@include('layouts.components.topnav')
	@include('layouts.components.sidebar')
	
	{{-- main content --}}
	<div class="pusher">
		<div class="main-content">
			{{$slot}}
		</div>
	</div>
	
	
	<!-- Scripts -->
	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
	@livewireScripts
	<script src="{{asset('js/jquery.js')}}"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/dataTables.semanticui.min.js')}}"></script>
	<script src="{{asset('semantic/semantic.js')}}"></script>
	<script src="{{asset('js/script.js')}}"></script>
	<script>
		window.livewire.on('selectdropdown', () => {
			$('.ui.dropdown').dropdown();
		});
		window.livewire.on('setCheckbox', () => {
			$(".ui.checkbox").checkbox();
		});
		window.livewire.on('downloadExcelMaintenance', () => {
			$("#downloadExcelMaintenance").modal('show');
			$('.ui.dropdown').dropdown();
		});
		window.livewire.on('exportExcelInventory', () => {
			$("#exportExcelInventory").modal('show');
			$('.ui.dropdown').dropdown();
		});
		window.livewire.on('uploadExcelInventory', () => {
			$("#uploadExcelInventory").modal('show');
			// 
			$("input:text, #attach").click(function() {
				$(this).parent().find("input:file").click();
			});
			$('input:file', '.ui.action.input')
			.on('change', function(e) {
				var name = e.target.files[0].name;
				$('input:text', $(e.target).parent()).val(name);
			});
		});
	</script>
	@stack('scripts')
</body>
</html>