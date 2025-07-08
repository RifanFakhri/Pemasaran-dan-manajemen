<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Customer;

class EditCustomer extends Component
{
    public $customerId;
    public $nama, $no_hp, $email, $tanggal_datang, $status;

    public function mount($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customerId = $customer->id;
        $this->nama = $customer->nama;
        $this->no_hp = $customer->no_hp;
        $this->email = $customer->email;
        $this->tanggal_datang = $customer->tanggal_datang;
        $this->status = $customer->status;
    }

    public function update()
{
    $this->validate([
        'nama' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'email' => 'required|email',
        'tanggal_datang' => 'required|date',
        'status' => 'required|in:baru,follow_up,tidak_tertarik',
    ]);

    $customer = Customer::findOrFail($this->customerId);
    $customer->update([
        'nama' => $this->nama,
        'no_hp' => $this->no_hp,
        'email' => $this->email,
        'tanggal_datang' => $this->tanggal_datang,
        'status' => $this->status,
    ]);

    $this->dispatch('customer-updated');
}

    public function render()
    {
        return view('livewire.admin.edit-customer')->layout('layouts.admin');
    }
}
