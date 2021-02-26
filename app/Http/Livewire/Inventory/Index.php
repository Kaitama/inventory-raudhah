<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;
use App\Models\Invdetail;
use App\Models\Section;
use App\Models\Kasi;

use Carbon\Carbon;

class Index extends Component
{
	use WithPagination;
	
	public $save = true, $section = null, $kasis = null, $trashed = false, $idtoedit, $form = false, $search = '';
	// input
	public $kasi_id, $obtained_at, $name, $quantity = 1, $unit, $price = 0, $from, $label, $description;
	
	// validation
	protected $rules = [
		'kasi_id'	=> 'required',
		'obtained_at'	=> 'required|date_format:d/m/Y',
		'name'	=> 'required',
		'quantity'	=> 'required|numeric|min:1',
		'price'	=> 'required|numeric|min:0',
	];
	protected $messages = [
		'kasi_id.required'	=> 'Kasi harus dipilih.',
		'obtained_at.required' => 'Tanggal perolehan tidak boleh kosong.',
		'obtained_at.date_format' => 'Format tanggal perolehan salah, dd/mm/yyyy.',
		'name.required'	=> 'Nama barang tidak boleh kosong.',
		'quantity.required'	=> 'Kuantitas tidak boleh kosong.',
		'quantity.numeric'	=> 'Kuantitas tidak valid.',
		'quantity.min'	=> 'Kuantitas tidak valid.',
		'price.required'	=> 'Harga satuan tidak boleh kosong.',
		'price.numeric'	=> 'Harga satuan tidak valid.',
		'price.min'	=> 'Harga satuan tidak valid.',
	];
	
	public function paginationView()
	{
		return 'vendor.livewire.semantic';
	}
	
	public function updatingSearch()
	{
		$this->resetPage();
	}
	
	public function render()
	{
		$s = '%' . $this->search . '%';
		$inventories = 
		Inventory::where('name', 'like', $s)
		->orWhere('from', 'like', $s)
		->orWhere('label', 'like', $s)
		->orWhere('description', 'like', $s)
		->orWhereHas('kasi', function ($query) {
			return $query->where('name', 'like', '%' . $this->search . '%');
		})
		->orWhereHas('kasi.section', function ($query) {
			return $query->where('name', 'like', '%' . $this->search . '%');
		})
		
		->orderBy('created_at')
		->paginate(25);
		$sections = Section::all();
		$this->emit('selectdropdown');
		$this->emit('setCheckbox');
		if(!$this->form && $this->idtoedit != null) $this->reset();
		return view('livewire.inventory.index', ['inventories' => $inventories, 'sections' => $sections, 'trasheds' => Inventory::onlyTrashed()->get(), 'allkasi' => Kasi::all()])
		->layout('layouts.semantic');
	}
	
	public function store()
	{
		$this->validate();
		$inventory = Inventory::create([
			'kasi_id'	=> $this->kasi_id,
			'obtained_at'	=> $this->convertDate($this->obtained_at),
			'name'	=> $this->name,
			'unit'	=> $this->unit,
			'price'	=> $this->price,
			'from'	=> $this->from,
			'label'	=> $this->label,
			'description'	=> $this->description,
			]
		);
		
		$a = str_replace('-', '', $inventory->obtained_at->toDateString());
		$b = Invdetail::withTrashed()->where('barcode', 'like', $a . '%')->get()->max();
		
		for ($i=1; $i <= $this->quantity; $i++) { 
			Invdetail::create([
				'inventory_id'	=> $inventory->id,
				'barcode'	=> $b ? $b->barcode + $i : $a . str_pad($i, 4, '0', STR_PAD_LEFT),
				]
			);
		}
		
		session()->flash('success', 'Data Inventaris berhasil disimpan.');
		$this->reset();
	}
	
	public function edit(Inventory $inventory)
	{
		$this->resetErrorBag();
		$this->form = true;
		$this->save = false;
		$this->idtoedit = $inventory->id;
		$this->section = $inventory->kasi->section->id;	
		$this->getKasi();
		$this->obtained_at = $inventory->obtained_at->format('d/m/Y');
		$this->name = $inventory->name;
		$this->quantity = $inventory->details->count();
		$this->unit = $inventory->unit;
		$this->price = $inventory->price;
		$this->from = $inventory->from;
		$this->label = $inventory->label;
		$this->description = $inventory->description;
	}
	
	public function update()
	{
		$this->validate();
		$inventory = Inventory::find($this->idtoedit);
		$old_quantity = $inventory->details->count();
		if ($this->quantity < $old_quantity) {
			$this->addError('quantity', 'Kuantitas tidak boleh kurang dari yang sudah ada.');
			return back();
		}
		$inventory->update([
			'kasi_id'	=> $this->kasi_id,
			'obtained_at'	=> $this->convertDate($this->obtained_at),
			'name'	=> $this->name,
			'unit'	=> $this->unit,
			'price'	=> $this->price,
			'from'	=> $this->from,
			'label'	=> $this->label,
			'description'	=> $this->description,	
			]
		);
		$a = str_replace('-', '', $inventory->obtained_at->toDateString());
		$b = Invdetail::withTrashed()->where('barcode', 'like', '%' . $a . '%')->get()->max();
		for ($i=1; $i <= $this->quantity - $old_quantity; $i++) { 
			Invdetail::create([
				'inventory_id'	=> $inventory->id,
				'barcode'	=> $b ? $b->barcode + $i : $a . str_pad($i, 4, '0', STR_PAD_LEFT),
				]
			);
		}
		
		session()->flash('success', 'Data Inventaris berhasil diubah.');
		$this->reset();
	}
	
	public function destroy(Inventory $inventory)
	{
		$inventory->delete();
		session()->flash('success', 'Data Inventaris berhasil dihapus.');
	}
	
	public function restore($id)
	{
		Inventory::onlyTrashed()->where('id', $id)->restore();
	}
	
	public function undo()
	{
		$this->resetErrorBag();
		$this->reset();
	}
	
	public function getKasi()
	{
		$this->kasis = Kasi::where('section_id', $this->section)->get();
		$this->kasi_id = $this->kasis->first()->id;
	}
	
	private function convertDate($date)
	{
		$d = explode('/' , $date);
		return $d[2] . '-' . $d[1] . '-' . $d[0];
	}
	
}