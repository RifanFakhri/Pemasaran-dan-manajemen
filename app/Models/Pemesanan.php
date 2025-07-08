<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan'; // 

    public $timestamps = true;

    protected $fillable = [
        'invoice',
        'rumah_id',
        'customer_id',  
        'jenis_pembayaran',
        'tanggal_pesan',
        'status_transaksi',
        'lama_angsuran',
        'uang_booking', 
        'uang_muka',
        'created_by',
        'bukti_booking',
        'bukti_dp',
    ];

    // Relasi dengan model Rumah
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }
    

    // Relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

     public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
     public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id');
    }
}
