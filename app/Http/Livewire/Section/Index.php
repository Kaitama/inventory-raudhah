<?php

namespace App\Http\Livewire\Section;

use Livewire\Component;
use App\Models\Section;

use Auth;

class Index extends Component
{
	public $sectionid, $name, $description;
	public $save = true, $trash = false;
	
	protected $messages = [
		'name.required' => 'Nama Biro / Bagian tidak boleh kosong.'
	];
	
	public function render()
	{
		$sections = Section::all();
		$trasheds = Section::onlyTrashed()->get();
		return view('livewire.section.index', ['sections' => $sections, 'trasheds' => $trasheds])
		->layout('layouts.semantic');
	}
	
	public function store()
	{
		$this->validate(['name'	=> 'required|max:255']);
		if($this->sectionid) {
			Section::find($this->sectionid)->update([
				'name'	=> $this->name,
				'description'	=> $this->description,
				]
			);
			session()->flash('success', 'Data Biro / Bagian berhasil diubah.');
		} else {
			Section::create([
				'name'	=> $this->name,
				'description'	=> $this->description,
				]
			);
			session()->flash('success', 'Data Biro / Bagian berhasil disimpan.');
		}
		$this->reset();
	}
	
	public function edit(Section $section)
	{
		$this->resetErrorBag();
		$this->sectionid = $section->id;
		$this->name = $section->name;
		$this->description = $section->description;
		$this->save = false;
	}
	
	public function destroy(Section $section)
	{
		$section->delete();
		session()->flash('success', 'Data Biro / Bagian berhasil dihapus.');
		$this->reset();
	}
	
	public function restore($id)
	{
		$this->resetErrorBag();
		Section::withTrashed()->where('id', $id)->restore();
	}
	
	public function undo()
	{
		$this->reset();
	}
}