@php
$s = Request::segment(2);
@endphp
<div class="ui sidebar vertical menu inverted sidebar-menu" id="sidebar">
	<div class="item">
		<img src="{{asset('img/app/logo.png')}}" class="ui small image circular centered" alt="Raudhah">
	</div>
	
	

	<a href="{{route('dashboard.index')}}" class="item{{$s == null ? ' active' : ''}}">
		<div>
			<i class="icon home grey"></i>
			Dashboard
		</div>
	</a>
	<a href="{{route('maintenances.index')}}" class="item{{$s == 'maintenances' ? ' active' : ''}}">
		<div>
			<i class="icon wrench grey"></i>
			Maintenance
		</div>
	</a>

	<div class="item">
		<div class="sidebar-header">
			Basis Data
		</div>
	</div>
	<a href="{{route('sections.index')}}" class="item{{$s == 'sections' ? ' active' : ''}}">
		<div>
			<i class="chart pie icon grey"></i>
			Data Bidang
		</div>
	</a>
	<a href="{{route('kasis.index')}}" class="item{{$s == 'kasis' ? ' active' : ''}}">
		<div>
			<i class="sitemap icon grey"></i>
			Data Kasi
		</div>
	</a>
	<a href="{{route('inventories.index')}}" class="item{{$s == 'inventories' ? ' active' : ''}}">
		<div>
			<i class="archive icon grey"></i>
			Data Inventaris
		</div>
	</a>
	<div class="item">
		<div class="sidebar-header">
			Manajemen
		</div>
	</div>
	<a href="{{route('users.index')}}" class="item{{$s == 'users' ? ' active' : ''}}">
		<div>
			<i class="users icon grey"></i>
			Pegawai
		</div>
	</a>
	

	<div class="ui basic inverted segment">
		<strong>&copy;{{date('Y')}} <a href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a></strong><br> 
		<small><br>Crafted by</small><br> <span class="jariyah-text">JARIYAH</span> Digital Solution
	</div>
	<div class="ui basic segment"></div>
</div>