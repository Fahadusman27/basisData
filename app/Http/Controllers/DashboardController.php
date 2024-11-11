<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengadaan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk summary cards
        $totalBarang = Barang::where('status_barang', 1)->count();
        $pengadaanBulanIni = Pengadaan::whereMonth('TIMESTAMP', Carbon::now()->month)
            ->whereYear('TIMESTAMP', Carbon::now()->year)
            ->count();
        $penjualanBulanIni = Penjualan::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $totalPendapatan = Penjualan::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_nilai');

        // Data untuk recent transactions
        $recentPengadaan = Pengadaan::with('vendor')
            ->orderBy('TIMESTAMP', 'desc')
            ->take(5)
            ->get();

        $recentPenjualan = Penjualan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Data untuk stock alerts
        $stockAlert = Barang::where('status_barang', 1)
            ->whereRaw('stok_tersedia <= minimum_stok * 1.5')
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'pengadaanBulanIni',
            'penjualanBulanIni',
            'totalPendapatan',
            'recentPengadaan',
            'recentPenjualan',
            'stockAlert'
        ));
    }
}
