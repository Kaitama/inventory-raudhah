<?php

namespace App\Http\Livewire\Kasi;

use Livewire\Component;
use App\Models\Kasi;
use App\Models\Section;

class Index extends Component
{
	
	
	public $kasiid, $section_id, $name, $description;
	public $save = true, $trash = false;
	
	protected $messages = [
		'section_id.required'	=> 'Bidang tidak boleh kosong.',
		'name.required' => 'Nama Kasi tidak boleh kosong.',
	];
	
	public function render()
	{
		$kasis = Kasi::all();
		$trasheds = Kasi::onlyTrashed()->get();
		$this->emit('selectdropdown');
		return view('livewire.kasi.index', ['kasis' => $kasis, 'trasheds' => $trasheds, 'sections' => Section::all()])
		->layout('layouts.semantic');
	}
	
	public function store()
	{
		$this->validate(['section_id' => 'required', 'name'	=> 'required|max:255',]);
		if($this->kasiid) {
			Kasi::find($this->kasiid)->update([
				'section_id'	=> $this->section_id,
				'name'	=> $this->name,
				'description'	=> $this->description,
				]
			);
			session()->flash('success', 'Data Kasi berhasil diubah.');
		} else {
			Kasi::create([
				'section_id'	=> $this->section_id,
				'name'	=> $this->name,
				'description'	=> $this->description,
				]
			);
			session()->flash('success', 'Data Kasi berhasil disimpan.');
		}
		$this->reset();
	}
	
	public function edit(Kasi $kasi)
	{
		$this->resetErrorBag();
		$this->kasiid = $kasi->id;
		$this->section_id = $kasi->section_id;
		$this->name = $kasi->name;
		$this->description = $kasi->description;
		$this->save = false;
	}
	
	public function destroy(Kasi $kasi)
	{
		$kasi->delete();
		session()->flash('success', 'Data Kasi berhasil dihapus.');
		$this->reset();
	}
	
	public function restore($id)
	{
		Kasi::onlyTrashed()->where('id', $id)->restore();
	}
	
	public function undo()
	{
		$this->resetErrorBag();
		$this->reset();
	}
	
}