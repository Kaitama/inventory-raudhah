<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\Invdetail;

class Show extends Component
{
	public $inventory;
	public $conditions = [
		1 => 'Baik',
		2 => 'Rusak',
		3	=> 'Hilang',
	];
	protected $listeners = ['refreshComponent' => '$refresh'];
	public function mount(Inventory $inventory)
	{
		$this->inventory = $inventory;
	}
	public function render()
	{
		
		return view('livewire.inventory.show')->layout('layouts.semantic');
	}

	public function destroy(Invdetail $inventory)
	{
		$inventory->delete();
		$this->emit('refreshComponent');
	}

	public function editCondition(Invdetail $item, $condition)
	{
		$item->update(['condition' => $condition]);
		$this->emit('refreshComponent');
	}
}