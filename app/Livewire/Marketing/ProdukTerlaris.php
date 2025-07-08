<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ProdukTerlaris extends Component
{
    public $search = '';

    public function render()
    {
        $rumahTerlaris = DB::table('bloks')
            ->leftJoin('rumah', function ($join) {
                $join->on('bloks.id', '=', 'rumah.blok_id')
                     ->where('rumah.status', 'terjual');
            })
            ->select('bloks.id', 'bloks.nama_blok', DB::raw('COUNT(rumah.id) as total_terjual'))
            ->when($this->search, function ($query) {
                $query->where('bloks.nama_blok', 'like', '%' . $this->search . '%');
            })
            ->groupBy('bloks.id', 'bloks.nama_blok')
            ->orderByDesc('total_terjual')
            ->get();

        return view('livewire.marketing.produk-terlaris', [
            'rumahTerlaris' => $rumahTerlaris
        ]);
    }
}
