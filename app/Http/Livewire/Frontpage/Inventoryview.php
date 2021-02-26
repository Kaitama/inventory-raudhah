<?php

namespace App\Http\Livewire\Frontpage;
use Auth;
use Livewire\Component;
use App\Models\Invdetail;
use App\Models\Maintainreport;

class Inventoryview extends Component
{
	public $barcode, $invdetail_id, $name, $phone, $description;
	
	public function mount($barcode)
	{
		$this->barcode = $barcode;
		if(Auth::user()) {
			$this->name = Auth::user()->name;
			$this->phone = Auth::user()->phone;
		}
	}
	public function render()
	{
		$item = Invdetail::where('barcode', $this->barcode)->first();
		$this->invdetail_id = $item->id;
		return view('livewire.frontpage.inventoryview', ['item' => $item])
		->layout('layouts.frontpage');
	}
	
	public function store()
	{
		$this->validate([
			'name'	=> 'required',
			'phone'	=> 'required'
		], [
			'name.required'	=> 'Nama lengkap tidak boleh kosong.',
			'phone.required'=> 'Nomor telepon tidak boleh kosong.'
			]
		);
		Maintainreport::create([
			'invdetail_id'	=> $this->invdetail_id,
			'name'	=> $this->name,
			'phone'	=> $this->phone,
			'description'	=> $this->description,
			'reported_at'	=> now(),
			]
		);
		return back()->with('success', 'Laporan kerusakan berhasil dikirim dan akan dikonfirmasi oleh administrator.');
	}
}