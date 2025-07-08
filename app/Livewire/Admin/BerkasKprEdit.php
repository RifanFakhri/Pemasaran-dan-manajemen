<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BerkasKpr;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;


class BerkasKprEdit extends Component
{
    use WithFileUploads;

    public $berkasId;
    public $customer_id;
    public $berkas = [
        'ktp' => null,
        'kk' => null,
        'surat_nikah' => null,
        'npwp' => null,
        'siup' => null,
        'jamsostek' => null,
        'kartu_pegawai' => null,
        'foto' => null,
        'surat_bekerja' => null,
        'sk_karyawan' => null,
        'slip_gaji' => null,
        'rekening' => null,
    ];
    public $existingFiles = [];

    protected $rules = [
        'customer_id' => 'required|exists:customers,id',
        'berkas.ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.surat_nikah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.siup' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.jamsostek' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.kartu_pegawai' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'berkas.surat_bekerja' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.sk_karyawan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.slip_gaji' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'berkas.rekening' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    public function mount($id)
    {
        $berkas = BerkasKpr::findOrFail($id);
        $this->berkasId = $id;
        $this->customer_id = $berkas->customer_id;
        
        // Simpan file yang sudah ada
        foreach ($this->berkas as $key => $value) {
            if ($berkas->$key) {
                $this->existingFiles[$key] = $berkas->$key;
            }
        }
    }

    public function update()
    {
        $this->validate();

        $berkas = BerkasKpr::findOrFail($this->berkasId);
        $customer = Customer::findOrFail($this->customer_id);
        $folder = 'berkas_kpr/' . str_replace(' ', '_', strtolower($customer->nama));

        $updateData = ['customer_id' => $this->customer_id];

        foreach ($this->berkas as $key => $file) {
            if ($file) {
                // Hapus file lama jika ada
                if (isset($this->existingFiles[$key])) {
                    Storage::disk('public')->delete($this->existingFiles[$key]);
                }
                
                // Simpan file baru
                $filename = $file->store($folder, 'public');
                $updateData[$key] = $filename;
            } elseif (isset($this->existingFiles[$key])) {
                // Pertahankan file yang sudah ada jika tidak diupdate
                $updateData[$key] = $this->existingFiles[$key];
            }
        }

        $berkas->update($updateData);

        $this->dispatch('edit-berkas');
    }

    public function removeFile($field)
    {
        if (isset($this->existingFiles[$field])) {
            Storage::disk('public')->delete($this->existingFiles[$field]);
            unset($this->existingFiles[$field]);
        }
        $this->berkas[$field] = null;
    }

    public function render()
    {
        return view('livewire.admin.berkas-kpr-edit', [
            'customers' => Customer::where('status', 'pembeli')->get(),
        ])->layout('layouts.admin');
    }
}
