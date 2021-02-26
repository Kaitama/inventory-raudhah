<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Section;
use App\Models\Kasi;
use App\Models\Inventory;
use App\Models\Invdetail;
use App\Models\Maintenance;
use App\Models\Maintainreport;


class Index extends Component
{
	public function render()
	{

		return view('livewire.dashboard.index', [
			'sections'		=> Section::all(),
			'kasis'				=> Kasi::all(),
			'inventories'	=> Inventory::all(),
			'details'			=> Invdetail::all(),
			'maintenances'=> Maintenance::all(),
			'reports'			=> Maintainreport::where('confirmed', false)->get(),
		]
		)->layout('layouts.semantic');
	}

	public function confirmreport(Maintainreport $report)
	{
		$report->update(['confirmed'	=> true]);
		Invdetail::find($report->invdetail_id)->update(['condition' => 2]);
		return back();
	}

	public function destroyreport(Maintainreport $report)
	{
		$report->delete();
		return back();
	}
}