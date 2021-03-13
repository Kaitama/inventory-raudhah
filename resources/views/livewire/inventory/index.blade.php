<div class="ui stackable grid">
	<div class="column">
		
		<div class="ui basic segment" style="padding-left: 0 !important; padding-right: 0 !important">
			
			<div class="ui text stackable menu">
				<div class="item">
					<div wire:click="$toggle('form')" class="ui labeled icon button {{$form == false ? 'black' : ''}}">
						@if(!$form)
						<i class="plus icon"></i> Tambah Data Inventaris
						@else
						<i class="times icon"></i> Cancel
						@endif
					</div>
				</div>
				<div class="right item">
						<a href="{{route('inventories.template')}}" class="ui labeled icon button basic">
							<i class="file excel icon"></i> Download Template
						</a>
						<div wire:click="$emit('uploadExcelInventory')" class="ui labeled icon button basic" style="margin-left: 2px; margin-right:2px">
							<i class="upload icon"></i> Import Excel
						</div>
						<div wire:click="$emit('exportExcelInventory')" class="ui labeled icon button basic">
							<i class="download icon"></i> Export Excel
						</div>
				</div>
			</div>

			{{-- export excel --}}
			<div id="exportExcelInventory" class="ui small modal">
				<div class="header">
					Export File Excel
				</div>
				<div class="content">
					<div class="description">
						
						<form action="{{route('inventories.export')}}" method="post" id="formDownload" class="ui form">
							@csrf
							
								<div class="field">
									<label>Kasi</label>
									<select class="ui dropdown" name="kasi_id">
										<option value="">Pilih Kasi</option>
										@forelse ($allkasi as $ks)
										<option value="{{$ks->id}}">{{$ks->name}}</option>
										@empty
										<option value="">Kasi masih kosong</option>
										@endforelse
									</select>
								</div>
						</form>
					</div>
				</div>
				<div class="actions">
					<div class="ui black deny button">
						Cancel
					</div>
					<div class="ui positive right labeled icon button" onclick="document.getElementById('formDownload').submit()">
						Export
						<i class="checkmark icon"></i>
					</div>
				</div>
			</div>
			{{-- upload excel --}}
			<div wire:ignore.self id="uploadExcelInventory" class="ui small modal">
				<div class="header">
					Upload File Excel
				</div>
				<div class="content">
					<div class="description">
						<p>Pastikan file Excel yang akan di upload telah mengikuti format template yang disediakan. <a href="{{route('inventories.template')}}">Klik disini</a> untuk mendownload template.</p>
						<form action="{{route('inventories.import')}}" method="post" id="formUpload" class="ui form" enctype="multipart/form-data">
							@csrf
							<div class="field">
								<div class="ui right labeled left icon action input">
									<i class="file excel icon"></i>
									<input type="text" class="fakefile" placeholder="Pilih file" readonly>
									<input type="file" name="inventories" id="realfile" style="display: none">
									<a id="attach" class="ui tag label fakefile">
										Browse
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="actions">
					<div class="ui black deny button">
						Cancel
					</div>
					<div class="ui positive right labeled icon button" onclick="document.getElementById('formUpload').submit()">
						Upload
						<i class="checkmark icon"></i>
					</div>
				</div>
			</div>
			
		</div>
		
		@include('layouts.components.flashmessages')
		
		@if($form)
		<div class="ui segments">
			<div class="ui segment inverted">
				<h4 class="ui header">{{$save ? 'Tambah' : 'Ubah'}} Inventaris</h4>
			</div>
			<div class="ui segment">
				<div class="ui form">
					<div class="three fields">
						<div class="field {{$sections->isEmpty() ? 'disabled' : ''}} required @error('section') error @enderror">
							<label>Bidang</label>
							<select class="ui dropdown" wire:change="getKasi" wire:model="section">
								<option value="">Pilih Bidang</option>
								@forelse ($sections as $section)
								<option value="{{$section->id}}">{{$section->name}}</option>
								@empty
								<option value="">Bidang masih kosong</option>
								@endforelse
							</select>
						</div>
						<div class="field {{$kasi_id == null ? 'disabled' : ''}} required @error('kasi_id') error @enderror">
							<label>Kasi</label>
							<select class="ui dropdown" wire:model="kasi_id">
								@if ($kasis)
								@forelse ($kasis as $kasi)
								<option value="{{$kasi->id}}">{{$kasi->name}}</option>
								@empty
								<option value="">Kasi masih kosong</option>
								@endforelse
								@else
								<option value="">Bidang belum dipilih</option>
								@endif
							</select>
						</div>
						<div class="field required @error('obtained_at') error @enderror">
							<label>Tanggal Perolehan</label>
							<input type="text" wire:model="obtained_at" placeholder="{{date('d/m/Y')}}">
						</div>
					</div>
					<div class="fields">
						<div class="ten wide field required @error('name') error @enderror">
							<label>Nama Barang</label>
							<input type="text" wire:model="name">
						</div>
						<div class="three wide field required @error('quantity') error @enderror">
							<label>Kuantitas</label>
							<input type="text" wire:model="quantity" style="text-align: right!important">
						</div>
						<div class="three wide field">
							<label>Unit</label>
							<input type="text" wire:model="unit" placeholder="Buah">
						</div>
					</div>
					<div class="three fields">
						<div class="field required @error('price') error @enderror">
							<label>Harga Satuan</label>
							<input type="text" wire:model="price" style="text-align: right!important">
						</div>
						<div class="field">
							<label>Asal</label>
							<input type="text" wire:model="from">
						</div>
						<div class="field">
							<label>Label</label>
							<input type="text" wire:model="label">
						</div>
					</div>
					<div class="field">
						<label>Keterangan</label>
						<textarea wire:model="description" rows="2"></textarea>
					</div>
				</div>
			</div>
			<div class="ui segment right aligned">
				@if (!$save)
				<div class="ui icon button" wire:click="undo">
					<i class="history icon"></i>
				</div>
				@endif
				<div class="ui labeled icon button basic" wire:click="{{$save ? 'store' : 'update'}}">
					<i class="{{$save ? 'save' : 'edit'}} icon"></i> {{$save ? 'Simpan' : 'Ubah'}}
				</div>
			</div>
		</div>
		@endif
		
		<div class="ui segments">
			<div class="ui inverted segment">
				<h4 class="ui header">Data Inventaris</h4>
			</div>
			
			<div class="ui segment">
				<div class="ui large search right icon input fluid">
					<input wire:model="search" type="text" placeholder="Cari inventaris">
					<i class="search icon"></i>
				</div>
			</div>
			
			<div class="ui segment">
				{{-- table --}}
				<div class="row">
					<div class="column">
						<table class="ui table">
							<thead>
								<tr>
									<th class="collapsing">#</th>
									<th class="collapsing">Bidang</th>
									<th>Perolehan</th>
									<th>Nama Barang</th>
									<th>Kuantitas</th>
									<th>Total</th>
									<th>Opsi</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($inventories as $no => $inventory)
								<tr wire:key={{$no}}>
									<td>{{$no + 1}}</td>
									<td>
										@if($inventory->kasi)
										<h5 class="ui header">{{$inventory->kasi->section ? $inventory->kasi->section->name : '-'}}
											<div class="sub header">{{$inventory->kasi->name}}</div>
										</h5>
										@else
										{{'-'}}
										@endif
									</td>
									<td class="collapsing">
										<h5 class="ui header">{{$inventory->obtained_at->isoFormat('LL')}}
											<div class="sub header">Dari {{$inventory->from ?? '-'}}</div>
										</h5>
									</td>
									<td>
										<h5 class="ui header">{{$inventory->name}}
											<div class="sub header">{{$inventory->description ?? '-'}}</div>
										</h5>
									</td>
									<td class="collapsing">
										<h5 class="ui header">{{$inventory->details->count()}} {{$inventory->unit ?? ''}}
											<div class="sub header">@ Rp. <span class="right floated">{{number_format($inventory->price, 0, ',', '.')}}</span></div>
										</h5>
									</td>
									<td class="collapsing">
										<h5 class="ui header">
											Rp. {{number_format($inventory->price * $inventory->details->count(), 0, ',', '.')}}
											<div class="sub header">{{$inventory->label ?? '-'}}</div>
										</h5>
									</td>
									<td class="collapsing center aligned">
										<div class="ui basic icon buttons">
											<a target="_blank" href="{{route('inventories.qrcode', $inventory->id)}}" class="ui button" data-tooltip="Download barcode" data-inverted="" data-position="left center">
												<i class="download icon"></i>
											</a>
											<a href="{{route('inventories.show', $inventory->id)}}" class="ui button" data-tooltip="Detail data" data-inverted="" data-position="left center">
												<i class="eye icon"></i>
											</a>
											<div wire:click="edit({{$inventory->id}})" class="ui button" data-tooltip="Ubah data" data-inverted="" data-position="left center">
												<i class="edit icon"></i>
											</div>
											<div wire:click="destroy({{$inventory->id}})" class="ui button" data-tooltip="Hapus data" data-inverted="" data-position="left center">
												<i class="trash icon"></i>
											</div>
										</div>
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="7">
										<div class="ui icon message">
											<i class="inbox icon"></i>
											<div class="content">
												<div class="header">Data masih kosong.</div>
												<p>Silahkan tambah data Inventaris melalui form yang disediakan.</p>
											</div>
										</div>
									</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="column">{{ $inventories->links() }}</div>
				</div>
			</div>

			@if($search && $inventories->isNotEmpty())
			<div class="ui segment right aligned">
				<div class="row">
					<div class="column">
						<div class="ui positive labeled icon button" wire:click="exportSearch">
							<i class="file excel icon"></i>
							Download Excel
						</div>
					</div>
				</div>
			</div>
			@endif
			
			<div class="ui segment right aligned">
				<div class="ui toggle checkbox">
					<input type="checkbox" tabindex="0" class="hidden" wire:model="trashed">
					<label>Tampilkan Inventaris yang dihapus.</label>
				</div>
			</div>
		</div>
		
		@if($trashed)
		<div class="ui segments">
			<div class="ui inverted red segment">
				<h4 class="ui header">Daftar Inventaris yang Dihapus</h4>
			</div>
			<div class="ui segment">
				{{-- table --}}
				<div class="row">
					<div class="column">
						<table class="ui table">
							<thead>
								<tr>
									<th class="collapsing">#</th>
									<th class="collapsing">Bidang</th>
									<th>Perolehan</th>
									<th>Nama Barang</th>
									<th>Kuantitas</th>
									<th>Total</th>
									<th>Opsi</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($trasheds->sortByDesc('created_at') as $trash)
								<tr>
									<td>1</td>
									<td>
										@if($trash->kasi)
										<h5 class="ui header">{{$trash->kasi->section ? $trash->kasi->section->name : '-'}}
											<div class="sub header">{{$trash->kasi->name}}</div>
										</h5>
										@else
										{{'-'}}
										@endif
									</td>
									<td class="collapsing">
										<h5 class="ui header">{{$trash->obtained_at->isoFormat('LL')}}
											<div class="sub header">Dari {{$trash->from ?? '-'}}</div>
										</h5>
									</td>
									<td>
										<h5 class="ui header">{{$trash->name}}
											<div class="sub header">{{$trash->description ?? '-'}}</div>
										</h5>
									</td>
									<td class="collapsing">
										<h5 class="ui header">{{$trash->details->count()}} {{$trash->unit ?? ''}}
											<div class="sub header">@ Rp. <span class="right floated">{{number_format($trash->price, 0, ',', '.')}}</span></div>
										</h5>
									</td>
									<td class="collapsing">
										<h5 class="ui header">
											Rp. {{number_format($trash->price * $trash->details->count(), 0, ',', '.')}}
											<div class="sub header">{{$trash->label ?? '-'}}</div>
										</h5>
									</td>
									<td class="collapsing center aligned">
										
										<div wire:click="restore({{$trash->id}})" class="ui basic icon button" data-tooltip="Kembalikan data" data-inverted="" data-position="left center">
											<i class="recycle icon"></i>
										</div>
										
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="7">
										<div class="ui icon message">
											<i class="inbox icon"></i>
											<div class="content">
												<div class="header">Data masih kosong.</div>
												<p>Belum ada data Inventaris yang dihapus.</p>
											</div>
										</div>
									</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		@endif
		
	</div>
	
</div>

