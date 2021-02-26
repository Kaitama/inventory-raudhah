@if(session()->has('success'))
<div class="ui positive icon message">
	<i class="icon checkmark"></i>
	<div class="content">
		<div class="header">Sukses!</div>
		{{ session('success') }}
	</div>
</div>
@endif

@if (session()->has('error') || $errors->any())
<div class="ui negative icon message">
	<i class="icon exclamation triangle"></i>
	<div class="content">
		<div class="header">Gagal!</div>
		{{ session('error') ?? $errors->first() }}
	</div>
</div>
@endif