<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class CustomerList extends Component
{
    use WithPagination;

    public $search = '';
    public $suggestions = [];

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset to page 1 when search changes
    }

    public function updatedSearch()
    {
        // Fetch suggestions based on search term & status filter
        $this->suggestions = Customer::where('nama', 'like', '%' . $this->search . '%')
            ->whereIn('status', ['baru', 'follow_up'])
            ->limit(5)
            ->get(['nama', 'status'])
            ->toArray();
    }

    public function selectUser($nama)
    {
        $this->search = $nama;
        $this->suggestions = [];
    }

    public function applySearch()
    {
        $this->suggestions = [];
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::query()
            ->whereIn('status', ['baru', 'follow_up', 'tidak_tertarik']) // Only show these statuses
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.customer-list', [
            'customers' => $customers
        ])->layout('layouts.admin');
    }
}
