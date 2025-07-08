<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TambahUser extends Component
{
    public $name, $username, $password, $role;

    // Validasi data form
    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,marketing',
        ]);

        // Buat user baru
        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password), // Menggunakan bcrypt
            'role' => $this->role,
        ]);

        // Reset form setelah submit
        $this->reset();

        // Dispatch browser event untuk menampilkan SweetAlert
        
        $this->dispatch('user-added');
    }

    // Render view
    public function render()
    {
        return view('livewire.admin.tambah-user')->layout('layouts.admin');
    }
}
