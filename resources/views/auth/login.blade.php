@extends('layouts.auth')

@section('content')
<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="{{asset('img/app/logo.png')}}" class="image">
      
    </h2>
		<form method="post" action="{{route('login')}}" class="ui large form">
			@csrf
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="Username">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
				</div>
				<div class="field">
					<div class="ui checkbox">
						<input type="checkbox" tabindex="0" name="remember">
						<label>Tetap login</label>
					</div>
				</div>
        <button type="submit" class="ui fluid large teal submit button">Login</button>
      </div>

      <div class="ui error message"></div>

    </form>

  </div>
</div>
@endsection