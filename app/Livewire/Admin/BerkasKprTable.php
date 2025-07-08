<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BerkasKpr;
use Illuminate\Support\Facades\Storage;

class BerkasKprTable extends Component
{
    use WithPagination;

    public $startDate, $endDate, $search = '', $perPage = 10;
    public $previewFilePath = null, $showPreview = false;
    public $selectedDocumentType = '', $isFilterApplied = false;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'selectedDocumentType' => ['except' => ''],
        'isFilterApplied' => ['except' => false]
    ];

    public function applyFilters()
    {
        $this->isFilterApplied = true;
        $this->resetPage();
    }

    public function updated($property)
    {
        if ($this->isFilterApplied && in_array($property, ['startDate', 'endDate', 'search', 'perPage', 'selectedDocumentType'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['startDate', 'endDate', 'search', 'selectedDocumentType', 'isFilterApplied']);
        $this->resetPage();
    }

    public function confirmDelete($id)
{
   
}

public function delete($id)
{
     $this->dispatch('swal:confirm', [
        'id' => $id,
        'type' => 'warning',
        'message' => 'Apakah Anda yakin ingin menghapus berkas ini?'
    ]);
    try {
        $berkas = BerkasKpr::findOrFail($id);

        $fields = [
            'ktp', 'kk', 'surat_nikah', 'npwp', 'siup', 'jamsostek',
            'kartu_pegawai', 'surat_bekerja', 'foto', 'sk_karyawan', 'slip_gaji', 'rekening'
        ];

        foreach ($fields as $field) {
            if ($berkas->$field && Storage::disk('public')->exists($berkas->$field)) {
                Storage::disk('public')->delete($berkas->$field);
            }
        }

        $berkas->delete();

        $this->dispatch('berkas-deleted');

    } catch (\Exception $e) {
        $this->dispatch('swal:modal', [
            'title' => 'Error',
            'text' => 'Gagal menghapus berkas: ' . $e->getMessage(),
            'type' => 'error'
        ]);
    }
}

    public function previewFile($id, $field)
    {
        $berkas = BerkasKpr::findOrFail($id);
        $filePath = $berkas->$field;

        if (!is_string($filePath) || !Storage::disk('public')->exists($filePath)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'File tidak ditemukan.'
            ]);
            return;
        }

        $this->previewFilePath = Storage::url($filePath);
        $this->showPreview = true;
    }

    public function closePreview()
    {
        $this->previewFilePath = null;
        $this->showPreview = false;
    }

    public function render()
    {
        $query = BerkasKpr::query()->with('customer')->latest();

        if ($this->isFilterApplied || $this->search) {
            if ($this->startDate) {
                $query->whereDate('created_at', '>=', $this->startDate);
            }

            if ($this->endDate) {
                $query->whereDate('created_at', '<=', $this->endDate);
            }

            if ($this->search) {
                $query->whereHas('customer', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->selectedDocumentType) {
                $query->whereNotNull($this->selectedDocumentType);
            }
        }

        $berkas = $query->paginate($this->perPage);

        $documentTypes = [
            'ktp' => 'KTP', 'kk' => 'Kartu Keluarga', 'surat_nikah' => 'Surat Nikah',
            'npwp' => 'NPWP', 'siup' => 'SIUP', 'jamsostek' => 'Jamsostek',
            'kartu_pegawai' => 'Kartu Pegawai', 'surat_bekerja' => 'surat bekerja','foto' => 'Foto',
            'sk_karyawan' => 'SK Karyawan', 'slip_gaji' => 'Slip Gaji',
            'rekening' => 'Rekening'
        ];

        return view('livewire.admin.berkas-kpr-table', [
            'berkas' => $berkas,
            'documentTypes' => $documentTypes
        ]);
    }
}
