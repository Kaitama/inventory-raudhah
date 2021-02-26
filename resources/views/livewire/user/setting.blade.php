<div class="ui stackable grid">
	<div class="five wide column">
		<div class="ui fluid card black">
			<div class="image">
				<img src="{{$user->photo ? url('img/users' . $user->photo) : url('img/users/nopic.png')}}">
			</div>
			<div class="content">
				<a class="header">{{ucfirst($user->name)}}</a>
				<div class="meta">
					<span class="date">Member sejak {{$user->created_at->diffForHumans()}}</span>
				</div>
				<div class="description">
					<div>
						<i class="user icon"></i>
						{{$user->username}}
					</div>
					<div>
						<i class="phone icon"></i>
						{{$user->phone}}
					</div>
					<div>
						<i class="mail icon"></i>
						{{$user->email}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="eleven wide column">
		@include('layouts.components.flashmessages')
		<div class="ui segments">
			<div class="ui black inverted segment">
				<h4 class="ui header">Edit Profile</h4>
			</div>
			<div class="ui segment">
				<div class="ui form error">
					<div class="field required @error('name') error @enderror">
						<label>Nama Lengkap</label>
						<input type="text" wire:model="name" readonly>
					</div>
						<div class="field required @error('email') error @enderror">
							<label>Email</label>
							<input type="text" wire:model="email">
						</div>
						<div class="field required @error('username') error @enderror">
							<label>Username</label>
							<input type="text" wire:model="username">
						</div>
						<div class="field required @error('phone') error @enderror">
							<label>Telepon / WhatsApp</label>
							<input type="text" wire:model="phone">
						</div>

				</div>
			</div>
			<div class="ui segment right aligned">
				<div wire:click="updateprofile({{Auth::id()}})" class="ui black labeled icon button">
					<i class="save icon"></i> Update Profile
				</div>
			</div>
		</div>
		<div class="ui segments">
			<div class="ui black inverted segment">
				<h4 class="ui header">Edit Password</h4>
			</div>
			<div class="ui segment">
				<div class="ui form error">
					<div class="field required @error('old_password') error @enderror">
						<label>Password Lama</label>
						<input type="password" wire:model="old_password">
					</div>
					<div class="field required @error('password') error @enderror">
						<label>Password Baru</label>
						<input type="password" wire:model="password">
					</div>
					<div class="field required">
						<label>Konfirmasi Password</label>
						<input type="password" wire:model="password_confirmation">
					</div>
				</div>
			</div>
			<div class="ui segment right aligned">
				<div wire:click="updatepassword({{Auth::id()}})" class="ui labeled icon button black">
					<i class="save icon"></i> Update Password
				</div>
			</div>
		</div>
	</div>
</div>