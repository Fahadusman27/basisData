<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class satuan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'satuan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_satuan',
        'keterangan'
    ];

    /**
     * Get all barang for the satuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
