<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KartuStok extends Model
{
    protected $table = 'kartu_stok';

    protected $fillable = [
        'barang_id',
        'tipe_transaksi',     // misalnya: masuk/keluar/adjustment
        'referensi_id',       // ID pengadaan/penjualan/adjustment
        'referensi_tipe',     // tipe referensi: pengadaan/penjualan/adjustment
        'jumlah',             // jumlah barang masuk/keluar
        'saldo_akhir',        // stok setelah transaksi
        'keterangan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'jumlah' => 'integer',
        'saldo_akhir' => 'integer'
    ];

    // Relasi dengan barang
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    // Scope untuk filter tanggal
    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query;
    }

    // Scope untuk filter barang
    public function scopeFilterByBarang($query, $barangId)
    {
        if ($barangId) {
            $query->where('barang_id', $barangId);
        }

        return $query;
    }

    // Helper method untuk mendapatkan tipe transaksi dalam format yang readable
    public function getTipeTransaksiLabelAttribute()
    {
        $labels = [
            'masuk' => 'Barang Masuk',
            'keluar' => 'Barang Keluar',
            'adjustment' => 'Penyesuaian Stok'
        ];

        return $labels[$this->tipe_transaksi] ?? $this->tipe_transaksi;
    }
}
