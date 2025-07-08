<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Blok;

class PerformaStaf extends Component
{
    public $bulan;
    public $tahun;
    public $performaStaf = [];
    public $bloks;

    public function mount()
    {
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
        $this->bloks = Blok::all();
    }

    public function render()
    {
        $target = 50000000;

        $pemesanan = Pemesanan::where('status_transaksi', 'lunas')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->with(['creator', 'rumah', 'rumah.blok'])
            ->get();

        $data = [];
        $groupedPemesanan = $pemesanan->groupBy('created_by');

        foreach ($groupedPemesanan as $created_by => $items) {
            $user = $items->first()->creator;
            if (!$user || $user->role !== 'marketing') continue;

            $total = $items->sum('uang_muka');
            $percent = ($total / $target) * 100;

            $totalTerjual = $items->count();

            $produk = [];
            foreach ($this->bloks as $blok) {
                $produk[$blok->id] = $items->filter(function ($item) use ($blok) {
                    return $item->rumah && $item->rumah->blok_id == $blok->id;
                })->count();
            }

            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'total' => $total,
                'percent' => round($percent),
                'color' => $percent >= 100 ? 'green' : ($percent >= 90 ? 'orange' : 'red'),
                'total_terjual' => $totalTerjual,
                'produk' => $produk,
            ];
        }

        usort($data, fn($a, $b) => $b['total'] <=> $a['total']);
        if (!empty($data)) {
            $data[0]['top'] = true;
        }

        $this->performaStaf = $data;

        return view('livewire.admin.performa-staf');
    }
}
