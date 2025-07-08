<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pemesanan;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class DataTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    public $suggestions = [];
    public $showPreview = false;
    public $previewFile = null;
    public $previewType = null;
    public $isPdf = false; // Added missing property

    protected $listeners = [
    'applySearch' => 'applySearch',
    'closePreview' => 'closePreview',
];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applySearch()
    {
        $this->suggestions = Customer::where(function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->whereHas('pemesanan', function ($q) {
            $q->whereIn('status_transaksi', ['belum', 'lunas']);
        })
        ->get()
        ->toArray();
    }

    public function previewFile($fileId, $fileType)
{
    $this->validate([
        'fileType' => 'in:booking,dp'
    ]);

    $transaction = Pemesanan::find($fileId);
    if (!$transaction) {
        $this->dispatch('notify', ['type' => 'error', 'message' => 'Transaksi tidak ditemukan']);
        return;
    }

    $filePath = $fileType === 'booking' 
        ? $transaction->bukti_booking 
        : $transaction->bukti_dp;

    if (!$filePath) {
        $this->dispatch('notify', ['type' => 'error', 'message' => 'File tidak ditemukan']);
        return;
    }

    $this->previewFile = Storage::exists($filePath) 
        ? Storage::url($filePath) 
        : asset($filePath);
        
    $this->previewType = $fileType;
    $this->showPreview = true;
    $this->isPdf = pathinfo($this->previewFile, PATHINFO_EXTENSION) === 'pdf';
}

    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewFile = null;
        $this->previewType = null;
    }

    public function render()
    {
        $transaksi = Pemesanan::with(['customer', 'rumah'])
            ->whereIn('status_transaksi', ['belum', 'lunas'])
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
            ->latest()
            ->paginate(10);

        return view('livewire.admin.data-transaksi', [
            'transaksi' => $transaksi,
        ])->layout('layouts.admin');
    }
}