<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerChartController extends Controller
{
    public function index()
    {
        // Ambil 9 bulan terakhir (April–Desember jika saat ini Desember)
        $now = Carbon::now();
        $startMonth = $now->copy()->subMonths(8);

        $labels = [];
        $data = [];

        for ($date = $startMonth; $date <= $now; $date->addMonth()) {
            $labels[] = $date->format('M'); // Contoh: Apr, May, Jun

            $count = DB::table('pemesanan')
                ->where('status_transaksi', 'lunas')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $data[] = $count;
        }

        return view('dashboard.admin.index', compact('labels', 'data'));
    }
}
