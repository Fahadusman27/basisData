<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class vendor extends Model
{
    protected $table = 'vendor';

    protected $fillable = [
        'nama_vendor',
        'alamat',
        'nomor_telepon',
        'email',
        'pic',  // Person In Charge
        'status_vendor', // aktif/nonaktif
        'keterangan'
    ];

    // Relasi dengan pengadaan
    public function pengadaan(): HasMany
    {
        return $this->hasMany(Pengadaan::class);
    }
}
