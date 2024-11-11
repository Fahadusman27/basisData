<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\DetailPengadaan;
use App\Models\Vendor;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaan = Pengadaan::with('vendor')->orderBy('TIMESTAMP', 'desc')->get();
        return view('pengadaan.index', compact('pengadaan'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $barang = Barang::where('status_barang', 1)->get();
        return view('pengadaan.create', compact('vendors', 'barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendor,id',
            'items' => 'required|array',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Hitung subtotal dan PPN
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['harga'];
            }
            $ppn = $subtotal * 0.11; // 11% PPN
            $total = $subtotal + $ppn;

            // Buat pengadaan
            $pengadaan = Pengadaan::create([
                'vendor_id' => $request->vendor_id,
                'subtotal_nilai' => $subtotal,
                'ppn' => $ppn,
                'total_nilai' => $total,
                'STATUS' => 'DRAFT'
            ]);

            // Simpan detail pengadaan
            foreach ($request->items as $item) {
                DetailPengadaan::create([
                    'pengadaan_id' => $pengadaan->id,
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['quantity'] * $item['harga']
                ]);
            }

            DB::commit();
            return redirect()->route('pengadaan.index')->with('success', 'Pengadaan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat membuat pengadaan');
        }
    }

    public function show(Pengadaan $pengadaan)
    {
        $pengadaan->load(['vendor', 'details.barang']);
        return view('pengadaan.show', compact('pengadaan'));
    }

    public function edit(Pengadaan $pengadaan)
    {
        if ($pengadaan->STATUS !== 'DRAFT') {
            return back()->with('error', 'Hanya pengadaan DRAFT yang dapat diedit');
        }

        $pengadaan->load(['vendor', 'details.barang']);
        $vendors = Vendor::all();
        $barang = Barang::where('status_barang', 1)->get();

        return view('pengadaan.edit', compact('pengadaan', 'vendors', 'barang'));
    }

    public function update(Request $request, Pengadaan $pengadaan)
    {
        if ($pengadaan->STATUS !== 'DRAFT') {
            return back()->with('error', 'Hanya pengadaan DRAFT yang dapat diupdate');
        }

        // Validasi dan update logic similar to store
        // ...
    }
}
