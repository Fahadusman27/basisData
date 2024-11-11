<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('satuan')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $satuan = Satuan::all();
        return view('barang.create', compact('satuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string',
            'satuan_id' => 'required|exists:satuan,id',
            'harga' => 'required|numeric',
            'minimum_stok' => 'required|integer',
            'status_barang' => 'boolean'
        ]);

        Barang::create($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        $satuan = Satuan::all();
        return view('barang.edit', compact('barang', 'satuan'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string',
            'satuan_id' => 'required|exists:satuan,id',
            'harga' => 'required|numeric',
            'minimum_stok' => 'required|integer',
            'status_barang' => 'boolean'
        ]);

        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
