<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rumah;
use App\Models\BerkasKpr;
use App\Models\Pemesanan;


use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Membatasi akses ke admin hanya untuk yang sudah login
    }
    
    public function index()
    {
        return view('dashboard.marketing.index');
    }

    public function cetak($id)
        {
            $pemesanan = Pemesanan::with(['customer', 'rumah'])->findOrFail($id);

            return view('dashboard.marketing.surat_keterangan_penjual', [
                'pemesanan' => $pemesanan,
            ]);
        }
}
