<?php

namespace App\Http\Livewire\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

use App\Models\User;

class Index extends Component
{
	public $name, $username, $email, $phone, $editing = false, $trash = false, $u;
	protected $messages = [
		'name.required'	=> 'Nama lengkap tidak boleh kosong.',
		'email.required'	=> 'Email tidak boleh kosong.',
		'email.email'	=> 'Email tidak valid.',
		'email.unique'	=> 'Email sudah terdaftar.',
		'username.required'	=> 'Username tidak boleh kosong.',
		'username.unique'	=> 'Username sudah terdaftar.',
		'phone.required'	=> 'Telepon / WhatsApp tidak boleh kosong.'
	];
	public function render()
	{
		$users = User::role('admin')->latest()->get();
		$trasheds = User::onlyTrashed()->get();
		return view('livewire.user.index', ['users' => $users, 'trasheds' => $trasheds])
		->layout('layouts.semantic');
	}
	
	public function store()
	{
		$this->validate([
			'name'	=> 'required',
			'email'	=> 'required|email|unique:users',
			'username'	=> 'required|unique:users',
			'phone'	=> 'required',
			]
		);
		
		User::create([
			'name'	=> $this->name,
			'username'	=> $this->username,
			'email'	=> $this->email,
			'phone'	=> $this->phone,
			'password'	=> Hash::make('password'),
			]
		);
		$this->reset();
		return back()->with('success', 'Pegawai berhasil ditambahkan.');
	}
	
	public function edit(User $user)
	{
		$this->editing = true;
		$this->u = $user->id;
		$this->name = $user->name;
		$this->email = $user->email;
		$this->username = $user->username;
		$this->phone = $user->phone;
	}
	
	public function update()
	{
		$this->validate([
			'name'	=> 'required',
			'email'	=> ['required','email',Rule::unique('users')->ignore($this->u)],
			'username'	=> ['required',Rule::unique('users')->ignore($this->u)],
			'phone'	=> 'required',
			]
		);
		User::find($this->u)->update([
			'name'	=> $this->name,
			'username'	=> $this->username,
			'email'	=> $this->email,
			'phone'	=> $this->phone,
			]
		);
		$this->reset();
		return back()->with('success', 'Data pegawai berhasil diubah.');
	}

	public function destroy(User $user)
	{
		$user->delete();
		$this->reset();
		return back()->with('success', 'Data pegawai berhasil dihapus.');
	}

	public function restore($id)
	{
		User::onlyTrashed()->find($id)->restore();
	}
	
	public function cancelupdate()
	{
		$this->reset();
	}
}