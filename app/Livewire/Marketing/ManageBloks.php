<?php


namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Blok;

class ManageBloks extends Component
{
    use WithPagination;

    public $search = ''; // Properti untuk pencarian
    protected $updatesQueryString = ['search'];
    

    public function applySearch()
    {
        $this->suggestions = [];
        $this->resetPage(); // Reset halaman paginasi
    }

    public function render()
{
    // Ambil blok dengan count rumah terjual dan tersedia
    $bloks = Blok::select('id', 'nama_blok')
        ->withCount([
            'rumah as rumah_tersedia' => function ($query) {
                $query->where('status', 'tersedia');
            },
            'rumah as rumah_terjual' => function ($query) {
                $query->where('status', 'terjual');
            },
        ])
        ->where('nama_blok', 'like', '%' . $this->search . '%')
        ->paginate(10);

    return view('livewire.marketing.manage-bloks', [
        'bloks' => $bloks
    ])->layout('layouts.marketing');        
}

}
