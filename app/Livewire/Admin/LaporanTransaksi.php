<?php

namespace App\Livewire\Admin;
use App\Exports\PemesananExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pemesanan;
use App\Models\Rumah;
use App\Models\Customer;
use App\Models\User;

class LaporanTransaksi extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $statusFilter = '';
    public $searchTerm = '';
    public $jenisPembayaranFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function render()
    {
        $pemesanans = Pemesanan::query()
            ->with(['rumah', 'customer', 'creator'])
            ->when($this->startDate, function ($query) {
                return $query->where('tanggal_pesan', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                return $query->where('tanggal_pesan', '<=', $this->endDate);
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status_transaksi', $this->statusFilter);
            })
            ->when($this->jenisPembayaranFilter, function ($query) {
                return $query->where('jenis_pembayaran', $this->jenisPembayaranFilter);
            })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($q) {
                    $q->where('invoice', 'like', '%'.$this->searchTerm.'%')
                      ->orWhereHas('customer', function ($q) {
                          $q->where('nama', 'like', '%'.$this->searchTerm.'%');
                      });
                });
            })
            ->latest()
            ->orderBy('tanggal_pesan', 'desc')
            ->paginate(6);

        return view('livewire.admin.laporan-transaksi', [
            'pemesanans' => $pemesanans,
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['startDate', 'endDate', 'statusFilter', 'searchTerm', 'jenisPembayaranFilter']);
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function exportToExcel(): BinaryFileResponse
    {
        $filename = 'laporan-transaksi-' . date('Y-m-d-H-i') . '.xlsx';
    
        return Excel::download(
            new PemesananExport(
                $this->startDate,
                $this->endDate,
                $this->statusFilter,
                $this->jenisPembayaranFilter,
                $this->searchTerm
            ),
            $filename
        );
    }
}
