<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rumah;

class RumahList extends Component
{
    use WithPagination;

    public $blokId;
    public $search = '';
    public $suggestions = [];

    public function mount($blokId = null)
    {
        $this->blokId = $blokId;
    }

    public function updatedSearch()
    {
        $this->suggestions = Rumah::where('blok_id', $this->blokId)
            ->where(function ($query) {
                $query->where('nomor_rumah', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->limit(5)
            ->get(['nomor_rumah', 'status']) // ambil data yang diperlukan
            ->toArray(); // supaya bisa digunakan di blade sebagai array
    }
    public function applySearch()
    {
        $this->suggestions = [];
        $this->resetPage(); // Reset halaman paginasi
    }
    public function selectUser($value)
    {
        $this->search = $value;
        $this->suggestions = [];
    }

    public function render()
    {
        $rumahs = Rumah::with('blok')
            ->where('blok_id', $this->blokId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nomor_rumah', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        return view('livewire.admin.rumah-list', [
            'rumahs' => $rumahs,
        ])->layout('layouts.admin');
    }
}
