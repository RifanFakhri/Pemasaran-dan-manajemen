<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasKpr extends Model
{
    protected $table = 'berkas_kpr';

    protected $fillable = [
        
        'customer_id',
        'ktp',
        'kk',
        'surat_nikah',
        'npwp',
        'siup',
        'jamsostek',
        'kartu_pegawai',
        'foto',
        'surat_bekerja',
        'sk_karyawan',
        'slip_gaji',
        'rekening',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
