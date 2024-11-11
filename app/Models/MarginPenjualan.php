<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarginPenjualan extends Model
{
    protected $table = 'margin_penjualan';

    protected $fillable = [
        'nama',              // nama kategori margin
        'persen',            // persentase margin
        'keterangan',        // deskripsi atau catatan
        'status',            // status aktif/nonaktif (1/0)
        'created_by',        // user yang membuat
        'updated_by'         // user yang terakhir update
    ];

    protected $casts = [
        'persen' => 'decimal:2',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi dengan penjualan
    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'margin_id');
        return $this->belongsTo(Penjualan::class);
    }

    // Scope untuk margin yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Accessor untuk format persen
    public function getPersenFormatAttribute()
    {
        return number_format($this->persen, 2) . '%';
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }

    // Relasi dengan user yang membuat
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan user yang update
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function margin_penjualan(){
        return $this->hasOne(MarginPenjualan::class);
    }
}
