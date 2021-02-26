<div class="ui stackable grid">
	<div class="five wide column">
		<div class="ui fluid card black">
			<div class="image">
				<img src="{{Auth::user()->photo ? url('img/users' . Auth::user()->photo) : url('img/users/nopic.png')}}">
			</div>
			<div class="content">
				<a class="header">{{ucfirst(Auth::user()->name)}}</a>
				<div class="meta">
					<span class="date">Member sejak {{Auth::user()->created_at->diffForHumans()}}</span>
				</div>
				<div class="description">
					<div>
						<i class="phone icon"></i>
						{{Auth::user()->phone}}
					</div>
					<div>
						<i class="mail icon"></i>
						{{Auth::user()->email}}
					</div>
				</div>
			</div>
			<div class="extra content right aligned">
				<a class="ui basic button" href="{{route('users.setting')}}">
					<i class="cog icon"></i> Settings
				</a>
			</div>
		</div>
	</div>
	<div class="eleven wide column">
		<h2 class="ui header">
			Statistik Inventaris
		</h2>
		<div class="ui stackable three columns center aligned grid">
			<div class="column">
				<div class="ui large statistic">
					<div class="value">
						{{number_format($sections->count(), 0, ',', '.')}}
					</div>
					<div class="label">Bidang</div>
				</div>
			</div>
			<div class="column">
				<div class="ui large statistic">
					<div class="value">
						{{number_format($kasis->count(), 0, ',', '.')}}
					</div>
					<div class="label">Kasi</div>
				</div>
			</div>
			<div class="column">
				<div class="ui large statistic">
					<div class="value">
						{{number_format($details->count(), 0, ',', '.')}}
					</div>
					<div class="label">Inventaris</div>
				</div>
			</div>
		</div>
		
		{{-- reports --}}
		<div class="ui segments">
			<div class="ui black inverted segment">
				<h4 class="ui header">Laporan Kerusakan Inventaris</h4>
			</div>
			<div class="ui segment">
				@if($reports->isNotEmpty())
				<table class="ui table">
					<thead>
						<tr>
							<th>#</th>
							<th>Pelapor</th>
							<th>Inventaris</th>
							<th>Bidang / Kasi</th>
							<th>Opsi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($reports as $no => $report)
						<tr>
							<td>{{++$no}}</td>
							<td>
								<h5 class="ui header">
									{{$report->name}}
									<div class="sub header">{{$report->reported_at->format('d/m/Y')}}</div>
								</h5>
							</td>
							<td>
								<h5 class="ui header">
									{{$report->invdetail->inventory->name}}
									<div class="sub header">{{$report->description ?? '-'}}</div>
								</h5>
							</td>
							<td>
								<h5 class="ui header">
									{{$report->invdetail->inventory->kasi->section->name}}
									<div class="sub header">{{$report->invdetail->inventory->kasi->name}}</div>
								</h5>
							</td>
							<td class="collapsing center aligned">
								<div class="ui basic icon buttons">
									<a target="_blank" href="{{route('inventoryview', $report->invdetail->barcode)}}" class="ui basic button" data-tooltip="Riwayat" data-inverted="" data-position="left center">
										<i class="eye icon"></i>
									</a>
									<div wire:click="confirmreport({{$report}})" class="ui positive button" data-tooltip="Konfirmasi" data-inverted="" data-position="left center">
										<i class="checkmark icon"></i>
									</div>
									<div wire:click="destroyreport({{$report}})" class="ui negative button" data-tooltip="Abaikan" data-inverted="" data-position="left center">
										<i class="trash icon"></i>
									</div>
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
						<div class="header">Empty</div>
						<p>Belum ada kerusakan inventaris yang dilaporkan.</p>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
