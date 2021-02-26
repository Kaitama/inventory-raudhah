<div class="ui stackable grid">
	
	<div class="row">
		<div class="column">
			<a href="{{route('inventories.index')}}" class="ui labeled icon basic button">
				<i class="chevron left icon"></i>Kembali
			</a>
			@include('layouts.components.flashmessages')
		</div>
	</div>
	
	<div class="six wide column">
		<div class="ui segments">
			<div class="ui black inverted segment">
				<h4 class="ui header">Detail Inventaris</h4>
			</div>
			<div class="ui segment">
				{{-- detail inventory --}}
				<div class="ui list">
					<div class="item">
						<div class="content">
							<div class="description">Bidang</div>
							<div class="header">{{$inventory->kasi->section->name}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Kasi</div>
							<div class="header">{{$inventory->kasi->name}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Tanggal Perolehan</div>
							<div class="header">{{$inventory->obtained_at->isoFormat('LL')}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Nama Inventaris</div>
							<div class="header">{{$inventory->name}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Kuantitas</div>
							<div class="header">{{$inventory->details->count()}} {{$inventory->unit}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Harga Satuan</div>
							<div class="header">Rp. <div class="right floated">{{number_format($inventory->price, 0, ',', '.')}}</div></div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Total</div>
							<div class="header">Rp. <div class="right floated">{{number_format($inventory->price * $inventory->details->count(), 0, ',', '.')}}</div></div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Asal</div>
							<div class="header">{{$inventory->from}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Label</div>
							<div class="header">{{$inventory->label}}</div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">Keterangan</div>
							<div class="header">{{$inventory->description}}</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="ten wide column">
		<div class="ui segments">
			<div class="ui black inverted segment">
				<h4 class="ui header">List Inventaris</h4>
			</div>
			<div class="ui segment">
				
				{{-- list inventory --}}
				<table class="ui table">
					<thead>
						<tr>
							<th>#</th>
							<th>Barcode</th>
							<th>Kondisi</th>
							<th>Opsi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($inventory->details as $no => $detail)
						<tr>
							<td class="collapsing right aligned">{{++$no}}</td>
							<td>{{$detail->barcode}}</td>
							<td class="">
								<div class="ui compact selection dropdown fluid">
									<div class="text">
										@switch($detail->condition)
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
									<i class="dropdown icon"></i>
									<div class="menu">
										@foreach ($conditions as $key => $condition)
										<div class="item {{$key == $detail->condition ? 'selected' : ''}}" wire:click="editCondition({{$detail->id}}, {{$key}})">{{$condition}}</div>
										@endforeach
									</div>
								</div>
							</td>
							<td class="collapsing">
								<div class="ui small basic icon buttons">
									<div wire:click="destroy({{$detail}})" class="ui button {{$inventory->details->count() == 1 ? 'disabled' : ''}}" data-tooltip="Delete Data" data-inverted="" data-position="left center">
										<i class="trash icon"></i>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>
