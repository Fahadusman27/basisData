<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPengadaan extends Model
{
    protected $table = 'detail_pengadaan';

    protected $fillable = [
        'pengadaan_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'keterangan'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    // Relasi dengan pengadaan
    public function pengadaan(): BelongsTo
    {
        return $this->belongsTo(Pengadaan::class);
    }

    // Relasi dengan barang
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
