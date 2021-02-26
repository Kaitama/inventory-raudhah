<?php

namespace App\Http\Livewire\Maintenance;

use Livewire\Component;
use App\Models\Invdetail;
use App\Models\Maintenance;

class Index extends Component
{
	public $search;
	public $form = false, $inv_id, $maintained_at, $name, $price = 0, $description;
	
	protected $rules = [
		'name'	=> 'required',
		'maintained_at'	=> 'required|date_format:d/m/Y',
		'price'	=> 'required|numeric|min:0',
	];
	protected $messages = [
		'maintained_at.required' => 'Tanggal tidak boleh kosong.',
		'maintained_at.date_format' => 'Format tanggal salah, dd/mm/yyyy.',
		'name.required'	=> 'Judul tidak boleh kosong.',
		'price.required'	=> 'Biaya tidak boleh kosong.',
		'price.numeric'	=> 'Biaya tidak valid.',
		'price.min'	=> 'Biaya tidak valid.',
	];
	
	public function render()
	{
		$item = null;
		if(strlen($this->search) == 12) {
			$item = Invdetail::where('barcode', $this->search)->first();
			if($item) $this->inv_id = $item->id;
		}
		return view('livewire.maintenance.index', ['item' => $item])->layout('layouts.semantic');
	}
	
	public function store()
	{
		$this->validate();
		Maintenance::create([
			'invdetail_id'	=> $this->inv_id,
			'name'	=> $this->name,
			'maintained_at'	=> $this->convertDate($this->maintained_at),
			'price'	=> $this->price,
			'description'	=> $this->description
			]
		);
		$this->reset();
		return back()->with('success', 'Data maintenance inventaris berhasil disimpan.');
	}

	public function destroy(Maintenance $maintenance)
	{
		$maintenance->delete();
		return back()->with('success', 'Data maintenance inventaris berhasil dihapus.');
	}
	
	
	private function convertDate($date)
	{
		$d = explode('/' , $date);
		return $d[2] . '-' . $d[1] . '-' . $d[0];
	}
}