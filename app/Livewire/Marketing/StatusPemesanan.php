<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\Pemesanan;

class StatusPemesanan extends Component
{
    public $perPage = 5;
    public $search = '';

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function render()
    {
        $pemesananTerbaru = Pemesanan::with(['rumah', 'customer'])
            ->when($this->search, function($query) {
                $query->whereHas('rumah', function($q) {
                    $q->where('nama_rumah', 'like', '%'.$this->search.'%');
                })
                ->orWhere('status_transaksi', 'like', '%'.$this->search.'%')
                ->orWhere('jenis_pembayaran', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->take($this->perPage)
            ->get();

        return view('livewire.marketing.status-pemesanan', [
            'pemesananTerbaru' => $pemesananTerbaru
        ])->layout('layouts.marketing');
    }
}
