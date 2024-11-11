<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'jumlah',
        'harga_jual',
        'total_harga',
        'keterangan'
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    // Relasi dengan penjualan
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }

    // Relasi dengan barang
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
