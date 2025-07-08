<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pemesanan;
use App\Models\Customer;

class DataPembeli extends Component
{
    use WithPagination;

    public $search = '';
    public $suggestions = [];

    public $tanggalPesan = null; // input tanggal

    protected $listeners = ['applySearch' => 'applySearch'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applySearch()
    {
        $this->suggestions = Customer::where('status', 'pembeli')
            ->where(function($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->get()
            ->toArray();
    }

    public function render()
    {
        $transaksi = Pemesanan::with(['customer', 'rumah'])
            ->whereHas('customer', function ($query) {
                $query->where('status', 'pembeli');
            })
            ->when($this->search, function ($query) {
                $query->where('invoice', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('rumah', function ($q) {
                        $q->where('nomor_rumah', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->tanggalPesan, function ($query) {
                $query->whereDate('tanggal_pesan', $this->tanggalPesan);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.marketing.data-pembeli', [
            'transaksi' => $transaksi,
        ])->layout('layouts.marketing');
    }
}
