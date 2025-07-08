<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Customer;

class CustomerForm extends Component
{
    public $nama, $no_hp, $email, $tanggal_datang, $status;

    protected $rules = [
        'nama' => 'required|string|max:20',
        'no_hp' => 'required|digits_between:10,12',
        'email' => 'required|email',
        'tanggal_datang' => 'required|date',
        'status' => 'required|in:baru,follow_up,booking,pembeli,cancelled',
    ];

    public function submit()
    {
        $this->validate();
    
        Customer::create([
            'nama' => $this->nama,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'tanggal_datang' => $this->tanggal_datang,
            'status' => $this->status,
        ]);
    
        $this->reset(); // Bersihkan input form
    
        // Emit event untuk browser JS (SweetAlert)
        $this->dispatch('customer-added');

    }

    public function render()
    {
        return view('livewire.admin.customer-form')
        ->layout('layouts.admin');
    }
}
