@if(session()->has('success'))
<div class="ui bottom attached positive message">
	<i class="icon checkmark"></i>
	{{ session('success') }}
</div>
@endif

@if (session()->has('error') || $errors->any())
<div class="ui bottom attached negative message">
	<i class="icon exclamation triangle"></i>
	{{ session('error') ?? $errors->first() }}
</div>
@endif