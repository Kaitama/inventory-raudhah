<div class="ui stackable grid">
	<div class="six wide column">
		<div class="ui segments">
			<div class="ui segment black inverted">
				<h4 class="ui header">{{$editing ? 'Ubah Data Pegawai' : 'Tambah Pegawai Baru'}}</h4>
			</div>
			<div class="ui segment">
				<div class="ui form error">
					<div class="field required @error('name') error @enderror">
						<label>Nama Lengkap</label>
						<input wire:model="name" type="text">
					</div>
					<div class="field required @error('email') error @enderror">
						<label>Email</label>
						<input wire:model="email" type="text">
					</div>
					<div class="field required @error('username') error @enderror">
						<label>Username</label>
						<input wire:model="username" type="text">
					</div>
					<div class="field required @error('phone') error @enderror">
						<label>Telepon / WhatsApp</label>
						<input wire:model="phone" type="text">
					</div>
					<div class="ui message">
						<p>Password default adalah <b>password</b>. Pegawai diharapkan segera mengganti passwordnya melalui akun masing-masing.</p>
					</div>
				</div>
			</div>
			<div class="ui segment right aligned">
				@if($editing)
				<div wire:click="cancelupdate" class="ui icon button" data-tooltip="Batalkan" data-inverted="" data-position="left center">
					<i class="undo icon"></i>
				</div>
				@endif
				<div wire:click="{{$editing ? 'update' : 'store'}}" class="ui labeled icon black button">
					<i class="save icon"></i> {{$editing ? 'Ubah' : 'Simpan'}}
				</div>
			</div>
			@include('layouts.components.flashmessage')
		</div>
	</div>
	
	<div class="ten wide column">
		<div class="ui segments">
			<div class="ui black inverted segment">
				<h4 class="ui header">Daftar Pegawai</h4>
			</div>
			<div class="ui segment">
				{{-- table --}}
				<table class="ui table">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Lengkap</th>
							<th>Email</th>
							<th>Username</th>
							<th>Telepon</th>
							<th>Opsi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $no => $user)
						<tr>
							<td class="collapsing">{{++$no}}</td>
							<td>
								<h5 class="ui header">
									{{$user->name}}
									<div class="sub header">
										{{$user->getRoleNames()->implode(',')}}
									</div>
								</h5>
							</td>
							<td>{{$user->email}}</td>
							<td>{{$user->username}}</td>
							<td class="collapsing">{{$user->phone}}</td>
							<td class="collapsing">
								<div class="ui basic icon buttons">
									<div wire:click="edit({{$user}})" class="ui button" data-tooltip="Edit" data-inverted="" data-position="left center">
										<i class="edit icon"></i>
									</div>
									<div wire:click="destroy({{$user}})" class="ui button" data-tooltip="Delete" data-inverted="" data-position="left center">
										<i class="trash icon"></i>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="ui segment right aligned">
				<div class="ui toggle checkbox">
					<input type="checkbox" tabindex="0" class="hidden" wire:model="trash">
					<label>Tampilkan Pegawai yang dihapus.</label>
				</div>
			</div>
		</div>
		
		@if($trash)
		<div class="ui segments">
			<div class="ui red inverted segment">
				<h4 class="ui header">Daftar Pegawai yang Dihapus</h4>
			</div>
			<div class="ui segment">
				@if($trasheds->isNotEmpty())
				{{-- table --}}
				<table class="ui table">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Lengkap</th>
							<th>Email</th>
							<th>Username</th>
							<th>Telepon</th>
							<th>Opsi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($trasheds as $no => $trashed)
						<tr>
							<td class="collapsing">{{++$no}}</td>
							<td>{{$trashed->name}}</td>
							<td>{{$trashed->email}}</td>
							<td>{{$trashed->username}}</td>
							<td class="collapsing">{{$trashed->phone}}</td>
							<td class="center aligned">
								<div wire:click="restore({{$trashed->id}})" class="ui icon button" data-tooltip="Kembalikan" data-inverted="" data-position="left center">
									<i class="recycle icon"></i>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<div class="ui message icon">
					<i class="inbox icon"></i>
					<div class="content">
						<div class="header">Empty</div>
						<p>Tidak ada data user yang dihapus.</p>
					</div>
				</div>
				@endif
			</div>
		</div>
		@endif
	</div>
</div>
