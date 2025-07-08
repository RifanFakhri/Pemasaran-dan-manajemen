<?php

namespace App\Livewire\Admin;
use Livewire\Component;
use App\Models\Blok;
use App\Models\Rumah;

class DashboardAdmin extends Component
{
    public $search = '';
    
    public function render()
    {
        // Data untuk tabel
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

        // Data untuk card dashboard
        $data = [
            'total_tersedia' => Rumah::where('status', 'tersedia')->count(),
            'total_terjual' => Rumah::where('status', 'terjual')->count(),
            'total_rumah' => Rumah::count(),
            'bloks' => $bloks
        ];

        return view('dashboard.admin.index', $data);
    }
}