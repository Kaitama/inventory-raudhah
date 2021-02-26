<?php

namespace App\Http\Livewire\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\User;
use Auth;

class Setting extends Component
{
	protected $messages = [
		'name.required'	=> 'Nama lengkap tidak boleh kosong.',
		'email.required'	=> 'Email tidak boleh kosong.',
		'email.email'	=> 'Email tidak valid.',
		'email.unique'	=> 'Email sudah terdaftar.',
		'username.required'	=> 'Username tidak boleh kosong.',
		'username.unique'	=> 'Username sudah terdaftar.',
		'phone.required'	=> 'Telepon / WhatsApp tidak boleh kosong.',
		'old_password.required'	=> 'Password lama tidak boleh kosong.',
		'password.required'	=> 'Password baru tidak boleh kosong.',
		'password.min'	=> 'Password minimal 8 karakter.',
		'password.confirmed'	=> 'Konfirmasi password salah.'
	];
	public $u, $name, $email, $username, $phone, $old_password, $password, $password_confirmation;
	public function mount()
	{
		$u = Auth::user();
		$this->u = $u->id;
		$this->name = $u->name;
		$this->email = $u->email;
		$this->username = $u->username;
		$this->phone = $u->phone;
	}
	public function render()
	{
		return view('livewire.user.setting', ['user' => Auth::user()])
		->layout('layouts.semantic');
	}
	
	public function updateprofile(User $user)
	{
		$this->validate([
			'name'	=> 'required',
			'email'	=> ['required','email',Rule::unique('users')->ignore($this->u)],
			'username'	=> ['required',Rule::unique('users')->ignore($this->u)],
			'phone'	=> 'required',
			]
		);
		$user->update([
			'email'	=> $this->email,
			'username'	=> $this->username,
			'phone'	=> $this->phone,
			]
		);
		return back()->with('success', 'Profil berhasil diubah.');
	}

	public function updatepassword(User $user)
	{
		$this->validate([
			'old_password'	=> 'required',
			'password'	=> 'required|min:8|confirmed'
		]
	);
	if (Hash::check($this->old_password, $user->password)) {
		$user->update(['password' => Hash::make($this->password)]);
		$this->reset(['password', 'old_password', 'password_confirmation']);
		return back()->with('success', 'Password berhasil diubah.');
	} else {
		$this->addError('old_password', 'Password lama anda salah.');
	}
	}
}