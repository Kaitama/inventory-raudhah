<div class="ui stackable grid">
	<div class="row">
		<div class="column">
			@include('layouts.components.flashmessages')
		</div>
	</div>
	<div class="row">
		<div class="column">
			<h1 class="ui header">
				{{$item->barcode}} - {{$item->inventory->name}}
				<div class="sub header">{{$item->inventory->description ?? ''}}</div>
			</h1>
			
			<div class="ui fluid card">
				<div class="content">
					<div class="header">
						Riwayat Maintenance
						<div wire:click="$emit('setModal')" class="ui labeled icon negative small button right floated">
							<i class="exclamation icon"></i>Laporkan rusak
						</div>
					</div>
				</div>
				<div class="content">
					<div class="ui sub header"></div>
					@if ($item->maintenance)
					<div class="ui list">
						@foreach ($item->maintenances->sortByDesc('maintained_at') as $maintain)
						<div class="item">
							<div class="content">
								<div class="header">{{$maintain->maintained_at->isoFormat('LL')}}</div>
								<div class="description">
									{{$maintain->name}}
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@else
					<div class="ui icon message">
						<i class="inbox icon"></i>
						<div class="content">
							<div class="header">Empty</div>
							<p>Tidak ada riwayat maintenance pada inventaris ini.</p>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	
	{{-- modal report --}}
	<div id="modalSubmitReport" class="ui modal">
		<div class="header">
			Profile Picture
		</div>
		<div class="content">
			<div class="description">
				<div class="ui form error">
					<div class="field required @error('name') error @enderror">
						<label>Nama Lengkap</label>
						<input type="text" wire:model="name" @auth readonly @endauth>
					</div>
					<div class="field required @error('phone') error @enderror">
						<label>Nomor Telepon / WhatsApp</label>
						<input type="text" wire:model="phone">
					</div>
					<div class="field">
						<label>Keterangan Kerusakan</label>
						<textarea wire:model="description" rows="2"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="actions">
			<div class="ui black deny button">
				Cancel
			</div>
			<div wire:click="store" class="ui positive right labeled icon button">
				Submit laporan
				<i class="checkmark icon"></i>
			</div>
		</div>
	</div>
	
</div>
