<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitOrganisasi extends Model
{
    protected $table = 'unit_organisasis';

    protected $fillable = [
        'nama',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function bagianSeksis(): HasMany
    {
        return $this->hasMany(BagianSeksi::class, 'unit_organisasi_id')
            ->orderBy('urutan')
            ->orderBy('id');
    }
}