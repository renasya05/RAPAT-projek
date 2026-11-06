<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $fillable = [
        'user_id',
        'aula_id',
        'nama_pemohon',
        'nip',
        'jabatan',
        'instansi',
        'unit_organisasi',
        'bagian_seksi',
        'peserta_asal',
        'tanggal_mulai',
        'tanggal_selesai',
        'kriteria_waktu',
        'jumlah_peserta',
        'keperluan',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Slot jam yang dipakai oleh sebuah kriteria waktu.
     * Full Day memakai semua slot, jadi jika Full Day sudah ada
     * maka pagi, siang, malam, dan Full Day semuanya tidak bisa dipilih.
     */
    public static function slotWaktu(?string $kriteria): array
    {
        return match ($kriteria) {
            'pagi_siang' => ['pagi'],
            'siang_sore' => ['siang'],
            'malam' => ['malam'],
            'full_day',
            'gabungan_pagi_siang',
            'gabungan_siang_malam',
            'gabungan_pagi_malam' => ['pagi', 'siang', 'malam'],
            null, '' => [],
            default => ['pagi', 'siang', 'malam'],
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function aula(): BelongsTo
    {
        return $this->belongsTo(Aula::class);
    }
}