<div class="ui stackable grid">
	
	<div class="row">
		<div class="right aligned column">
				<div wire:click="$emit('downloadExcelMaintenance')" class="ui labeled icon basic button">
					<i class="download icon"></i> Download Laporan
				</div>
			{{-- export excel --}}
			<div id="downloadExcelMaintenance" class="ui small modal">
				<div class="header">
					Export File Excel
				</div>
				<div class="content">
					<div class="description">
						
						<form action="{{route('maintenances.export')}}" method="post" id="formDownload" class="ui form">
							@csrf
							
							<div class="two fields">
								<div class="field required">
									<label>Dari Tanggal</label>
									<input type="text" name="from" value="{{now()->firstOfMonth()->format('d/m/Y')}}">
								</div>
								<div class="field required">
									<label>Sampai Tanggal</label>
									<input type="text" name="to" value="{{today()->format('d/m/Y')}}">
								</div>
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
			
		</div>
	</div>
	
	<div class="row">
		<div class="column">
			<div class="ui input icon huge fluid">
				<input wire:model="search" type="text" placeholder="Input nomor barcode" autofocus>
				<i class="search icon"></i>
			</div>
		</div>
	</div>
	
	<div class="row">
		@if ($item && $item->inventory)
		<div class="six wide column">
			<div class="ui segments">
				
				<div class="ui black inverted segment">
					<h4 class="ui header">Inventaris</h4>
				</div>
				<div class="ui segment">
					<div class="ui list">
						<div class="item">
							<div class="content">
								<div class="description">Kode Barcode</div>
								<div class="header">{{$item->barcode}}</div>
							</div>
						</div>
						<div class="item">
							<div class="content">
								<div class="description">Nama Inventaris</div>
								<div class="header">{{$item->inventory->name}}</div>
							</div>
						</div>
						<div class="item">
							<div class="content">
								<div class="description">Kondisi</div>
								<div class="header">
									@switch($item->condition)
									@case(1)
									Baik
									@break
									@case(2)
									Rusak
									@break
									@default
									Hilang
									@endswitch
								</div>
							</div>
						</div>
						<div class="item">
							<div class="content">
								<div class="description">Keterangan</div>
								<div class="header">{{$item->inventory->description}}</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="ten wide column">
			<div class="ui segments">
				<div class="ui black inverted segment">
					<h4 class="ui header">Riwayat Maintenance</h4>
				</div>
				<div class="ui segment">
					<div wire:click="$toggle('form')" class="ui {{$form ? '' : 'basic'}} labeled icon button">
						<i class="{{$form ? 'times' : 'plus'}} icon"></i> {{$form ? 'Cancel' : 'Tambah'}}
					</div>
				</div>
				@if(session()->has('error') || $errors->any() || session()->has('success'))
				<div class="ui segment">
					@include('layouts.components.flashmessages')
				</div>
				@endif
				@if($form)
				<div class="ui segment">
					<div class="ui form error">
						<div class="field required">
							<label>Judul</label>
							<input type="text" wire:model="name">
						</div>
						<div class="two fields">
							<div class="field required">
								<label>Tanggal</label>
								<input type="text" wire:model="maintained_at">
							</div>
							<div class="field">
								<label>Biaya</label>
								<input type="text" wire:model="price">
							</div>
						</div>
						<div class="field">
							<label>Deskripsi</label>
							<textarea wire:model="description" rows="2"></textarea>
						</div>
					</div>
				</div>
				<div class="ui segment right aligned">
					<div wire:click="store" class="ui basic labeled icon button">
						<i class="save icon"></i>Simpan
					</div>
				</div>
				@endif
				<div class="ui segment">
					@if ($item->maintenances->count() > 0)
					<table class="ui table">
						<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Perbaikan</th>
								<th>Biaya</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($item->maintenances as $no => $maintenance)
							<tr>
								<td class="collapsing right aligned">{{++$no}}</td>
								<td class="collapsing">{{$maintenance->maintained_at->isoFormat('LL')}}</td>
								<td>
									<h5 class="ui header">
										{{$maintenance->name}}
										<div class="sub header">{{$maintenance->description}}</div>
									</h5>
								</td>
								<td class="collapsing">Rp. {{number_format($maintenance->price, 0, ',', '.')}}</td>
								<td class="collapsing">
									<div wire:click="destroy({{$maintenance->id}})" class="ui small icon button basic">
										<i class="trash icon"></i>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
					<div class="ui icon message">
						<i class="inbox icon"></i>
						<div class="content">
							<div class="header">Riwayat kosong!</div>
							<p>Belum ada riwayat maintenance inventaris ini.</p>
						</div>
					</div>
					@endif
					
				</div>
			</div>
		</div>
		
		@else
		<div class="column">
			<div class="ui segment">
				<div class="ui icon message">
					<i class="inbox icon"></i>
					<div class="content">
						<div class="header">Not found!</div>
						<p>Lakukan pencarian dengan mengisi nomor barcode inventaris.</p>
					</div>
				</div>
			</div>
		</div>
		
		@endif
	</div>
	