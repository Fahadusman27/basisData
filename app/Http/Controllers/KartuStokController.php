<?php

namespace App\Http\Controllers;

use App\Models\KartuStok;
use App\Models\Barang;
use Illuminate\Http\Request;

class KartuStokController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::where('status_barang', 1)->get();

        $query = KartuStok::query();

        if ($request->filled('barang')) {
            $query->where('barang_id', $request->barang);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $kartuStok = $query->orderBy('created_at', 'desc')->get();

        return view('kartu-stok.index', compact('barang', 'kartuStok'));
    }
}
