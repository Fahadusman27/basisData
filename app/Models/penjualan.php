<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'nomor_penjualan',
        'user_id',
        'total_nilai',
        'status_penjualan',
        'keterangan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'total_nilai' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'User tidak tersedia'
        ]);
    }

    public function detailPenjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
