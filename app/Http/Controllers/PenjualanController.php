<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\MarginPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['user', 'margin_penjualan'])->orderBy('created_at', 'desc')->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $barang = Barang::where('status_barang', 1)
            ->where('stok_tersedia', '>', 0)
            ->get();
        $margins = MarginPenjualan::where('status', 1)->get();

        return view('penjualan.create', compact('barang', 'margins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'margin_id' => 'required|exists:margin_penjualan,id',
            'items' => 'required|array',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $margin = MarginPenjualan::findOrFail($request->margin_id);
            $subtotal = 0;

            // Validate stock and calculate subtotal
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                if ($barang->stok_tersedia < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk " . $barang->nama);
                }
                $subtotal += $barang->harga * $item['quantity'];
            }

            // Calculate final values
            $marginValue = $subtotal * ($margin->persen / 100);
            $subtotalWithMargin = $subtotal + $marginValue;
            $ppn = $subtotalWithMargin * 0.11;
            $total = $subtotalWithMargin + $ppn;

            // Create penjualan
            $penjualan = Penjualan::create([
                'user_id' => Auth::id(),
                'margin_id' => $request->margin_id,
                'subtotal_nilai' => $subtotalWithMargin,
                'ppn' => $ppn,
                'total_nilai' => $total
            ]);

            // Create details and update stock
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga' => $barang->harga,
                    'subtotal' => $barang->harga * $item['quantity']
                ]);

                // Update stock
                $barang->stok_tersedia -= $item['quantity'];
                $barang->save();
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['user', 'margin_penjualan', 'details.barang']);
        return view('penjualan.show', compact('penjualan'));
    }
}
