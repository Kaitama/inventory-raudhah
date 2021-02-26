<nav class="ui top inverted fixed menu">
	<div class="left menu">
		<a href="#" class="sidebar-menu-toggler item" data-target="#sidebar">
			<i class="sidebar icon"></i>
		</a>
		<a href="{{url('/')}}" class="header item" style="width: 210px !important">
			{{config('app.name')}}
		</a>
	</div>
	
	<div class="right menu">
		@auth
		<div class="ui dropdown item">
			<img class="ui avatar image" src="{{Auth::user()->photo ? url('img/users' . Auth::user()->photo) : url('img/users/nopic.png')}}">
			<span class="nav-username">{{ucfirst(Auth::user()->username)}}</span>
			<div class="menu">
				<a href="{{route('users.setting')}}" class="item">
					<i class="cog icon"></i>
					Setting
				</a>
				<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="item">
					<i class="sign-out icon"></i>
					Logout
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
					@csrf
			</form>
			</div>
		</div>

		@else
		<a class="ui item" href="{{route('login')}}">Login</a>
		@endauth
	</div>
</nav>