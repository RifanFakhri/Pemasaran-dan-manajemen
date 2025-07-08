<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Models\BerkasKpr;
use Illuminate\Support\Facades\Storage;

class BerkasKprForm extends Component
{
    use WithFileUploads;

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

    public function submit()
    {
        $this->validate();

        $customer = Customer::where('id', $this->customer_id)
                          ->where('status', 'pembeli')
                          ->firstOrFail();

        // Buat folder penyimpanan
        $folder = 'berkas_kpr/' . str_replace(' ', '_', strtolower($customer->nama));
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        // Siapkan data untuk disimpan
        $berkasData = [
            'customer_id' => $this->customer_id, // Hanya simpan customer_id
        ];

        foreach ($this->berkas as $key => $file) {
            if ($file) {
                $filename = $file->store($folder, 'public');
                $berkasData[$key] = $filename;
            }
        }
        

        // Simpan ke database
        BerkasKpr::create($berkasData);

        $this->dispatch('tambah-berkas');
        $this->reset(['customer_id', 'berkas']);
        
        session()->flash('message', 'Berkas berhasil diupload!');
    }

    public function render()
    {
        return view('livewire.admin.berkas-kpr-form', [
            'customers' => Customer::where('status', 'pembeli')->get(),
        ]);
    }
}