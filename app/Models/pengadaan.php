<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pengadaan extends Model
{
    protected $table = 'pengadaan';

    protected $fillable = [
        'nomor_pengadaan',
        'vendor_id',
        'total_nilai',
        'TIMESTAMP',
        'status_pengadaan',
        'keterangan'
    ];

    protected $casts = [
        'TIMESTAMP' => 'datetime',
        'total_nilai' => 'decimal:2'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withDefault([
            'nama_vendor' => 'Vendor tidak tersedia'
        ]);
    }

    public function detailPengadaan(): HasMany
    {
        return $this->hasMany(DetailPengadaan::class);
    }
}
