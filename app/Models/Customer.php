<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'nama', 'no_hp', 'email', 'tanggal_datang', 'status',
    ];

    // Relasi dengan model Pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'customer_id');
    }
}
