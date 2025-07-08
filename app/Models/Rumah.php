<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $table = 'rumah';

    protected $fillable = [
        'blok_id',
        'nomor_rumah',
        'luas_tanah',
        'luas_bangunan',
        'harga',
        'status', // misal: tersedia, terjual
    ];

   
    public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id');
    }
    public function pemesanan()
    {
    return $this->hasMany(Pemesanan::class);
    }

}