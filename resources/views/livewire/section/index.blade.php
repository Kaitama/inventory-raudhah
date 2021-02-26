<div class="ui stackable grid">
	<div class="six wide column">
		<div class="ui segments">
			<div class="ui segment black inverted">
				<h4 class="ui header">{{$save ? 'Tambah' : 'Ubah'}} Bidang</h4>
			</div>
			<div class="ui segment">
				<div class="ui form error">
					<div class="field required @error('name') error @enderror">
						<label>Nama Bidang</label>
						<input type="text" wire:model.lazy="name">
					</div>
					<div class="field">
						<label>Keterangan</label>
						<textarea rows="3" wire:model.lazy="description"></textarea>
					</div>
				</div>
			</div>
			<div class="ui segment right aligned">
				@if (!$save)
				<div class="ui icon button" wire:click="undo">
					<i class="history icon"></i>
				</div>
				@endif
				<div class="ui labeled icon button basic" wire:click="store">
					<i class="{{$save ? 'save' : 'edit'}} icon"></i> {{$save ? 'Simpan' : 'Ubah'}}
				</div>
			</div>
			@include('layouts.components.flashmessage')
		</div>
	</div>
	
	<div class="ten wide column">
		<div class="ui segments">
			<div class="ui segment black inverted">
				<h4 class="ui header">Daftar Bidang</h4>
			</div>
			<div class="ui segment">
				
				<table class="ui table">
					<thead>
						<tr>
							<th class="collapsing">No.</th>
							<th>Nama Bidang</th>
							<th class="collapsing">Kasi</th>
							<th class="collapsing">Opsi</th>
						</tr>
					</thead>
					<tbody>
						@php $no = 1 @endphp
						@forelse ($sections as $section)
						<tr>
							<td class="right aligned">{{$no++}}</td>
							<td>
								<h5 class="ui header">{{$section->name}}
									<div class="sub header">{{$section->description ?? '-'}}</div>
								</h5>
							</td>
							<td class="right aligned">
								{{$section->kasis->count()}}
							</td>
							<td>
								<div class="ui basic small icon buttons">
									<div class="ui button" wire:click="edit({{$section->id}})" data-tooltip="Ubah data" data-inverted="" data-position="left center">
										<i class="edit icon"></i>
									</div>
									<div class="ui button" wire:click="destroy({{$section->id}})" data-tooltip="Hapus data" data-inverted="" data-position="left center">
										<i class="trash icon"></i>
									</div>
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="4">
								<div class="ui icon message">
									<i class="inbox icon"></i>
									<div class="content">
										<div class="header">Data masih kosong.</div>
										<p>Silahkan tambah data Bidang melalui form yang disediakan.</p>
									</div>
								</div>
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				
			</div>
			<div class="ui segment right aligned">
				<div class="ui toggle checkbox">
					<input type="checkbox" tabindex="0" class="hidden" wire:model="trash">
					<label>Tampilkan Bidang yang dihapus.</label>
				</div>
			</div>
		</div>
		
		{{-- trashed --}}
		@if($trash)
		<div class="ui segments">
			<div class="ui segment red inverted">
				<h4 class="ui header">Daftar Bidang yang Dihapus</h4>
			</div>
			<div class="ui segment">

				<table class="ui table">
					<thead>
						<tr>
							<th class="collapsing">No.</th>
							<th>Nama Bidang</th>
							<th class="collapsing">Kasi</th>
							<th class="collapsing">Opsi</th>
						</tr>
					</thead>
					<tbody>
						@php $no = 1 @endphp
						@forelse ($trasheds as $trash)
						<tr>
							<td class="right aligned">{{$no++}}</td>
							<td>
								<h5 class="ui header">{{$trash->name}}
									<div class="sub header">{{$trash->description ?? '-'}}</div>
								</h5>
							</td>
							<td class="right aligned">
								{{$trash->kasi ? $trash->kasi->count() : 0}}
							</td>
							<td>
								<div class="ui basic small icon buttons">
									<div class="ui button" wire:click="restore({{$trash->id}})" data-tooltip="Kembalikan data" data-inverted="" data-position="left center">
										<i class="recycle icon"></i>
									</div>
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="4">
								<div class="ui icon message">
									<i class="inbox icon"></i>
									<div class="content">
										<div class="header">Data masih kosong.</div>
										<p>Silahkan tambah data Bidang melalui form yang disediakan.</p>
									</div>
								</div>
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>

			</div>
		</div>
		@endif
	</div>
</div>
