<div class="ui stackable grid">
	<div class="six wide column">
		<div class="ui segments">
			<div class="ui segment black inverted">
				<h4 class="ui header">{{$save ? 'Tambah' : 'Ubah'}} Kasi</h4>
			</div>
			<div class="ui segment">
				<div class="ui form error">
					<div class="field required @error('section_id') error @enderror @if($sections->isEmpty()) error disabled @endif">
						<label>Bidang</label>
						<select class="ui search dropdown" wire:model="section_id">
							<option value=""></option>
							@forelse ($sections as $section)
							<option value="{{$section->id}}">{{$section->name}}</option>
							@empty
							<option value="">Bidang masih kosong</option>
							@endforelse
						</select>
					</div>
					<div class="field required @error('name') error @enderror">
						<label>Nama Kasi</label>
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
				<h4 class="ui header">Daftar Kasi</h4>
			</div>
			<div class="ui segment">
				
				<table class="ui table">
					<thead>
						<tr>
							<th class="collapsing">No.</th>
							<th>Nama Kasi</th>
							<th class="collapsing">Bidang</th>
							<th class="collapsing">Opsi</th>
						</tr>
					</thead>
					<tbody>
						@php $no = 1 @endphp
						@forelse ($kasis as $kasi)
						<tr>
							<td class="right aligned">{{$no++}}</td>
							<td>
								<h5 class="ui header">
									{{$kasi->name}}
									<div class="sub header">{{$kasi->description ?? '-'}}</div>
								</h5>
							</td>
							<td>{{$kasi->section->name ?? '-'}}</td>
							<td>
								<div class="ui basic small icon buttons">
									<div class="ui button" wire:click="edit({{$kasi->id}})" data-tooltip="Ubah data" data-inverted="" data-position="left center">
										<i class="edit icon"></i>
									</div>
									<div class="ui button" wire:click="destroy({{$kasi->id}})" data-tooltip="Hapus data" data-inverted="" data-position="left center">
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
										<p>Silahkan tambah data Kasi melalui form yang disediakan.</p>
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
					<label>Tampilkan Kasi yang dihapus.</label>
				</div>
			</div>
		</div>
		
		{{-- trashed --}}
		@if($trash)
		<div class="ui segments">
			<div class="ui segment red inverted">
				<h4 class="ui header">Daftar Kasi yang Dihapus</h4>
			</div>
			<div class="ui segment">
				
				<table class="ui table">
					<thead>
						<tr>
							<th class="collapsing">No.</th>
							<th>Nama Kasi</th>
							<th class="collapsing">Bidang</th>
							<th class="collapsing">Opsi</th>
						</tr>
					</thead>
					<tbody>
						@php $no = 1 @endphp
						@forelse ($trasheds as $trash)
						<tr>
							<td class="right aligned">{{$no++}}</td>
							<td>
								<h5 class="ui header">
									{{$trash->name}}
									<div class="sub header">{{$trash->description ?? '-'}}</div>
								</h5>
							</td>
							<td>{{$trash->section->name ?? '-'}}</td>
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
										<p>Belum ada data Kasi yang dihapus.</p>
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
