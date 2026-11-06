<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected function user(string $role = 'user'): User
    {
        return User::factory()->create(['role' => $role]);
    }

    protected function aula(int $kapasitas = 100): Aula
    {
        return Aula::create([
            'nama_aula' => 'Aula Besar',
            'kapasitas' => $kapasitas,
            'keterangan' => 'Aula kapasitas besar.',
            'fasilitas' => 'Kursi, sound system',
        ]);
    }

    /**
     * Payload valid untuk form pendaftaran.
     */
    protected function payload(array $override = []): array
    {
        return array_merge([
            'aula_id' => 1,
            'nama_pemohon' => 'Budi Santoso',
            'jabatan' => 'Analis',
            'peserta_asal' => 'internal',
            'unit_organisasi' => 'Sekretariat',
            'bagian_seksi' => 'Subbagian Umum dan Kepegawaian',
            'instansi' => 'DISKOMINFO',
            'tanggal_mulai' => now()->addDays(3)->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(3)->format('Y-m-d'),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat koordinasi',
        ], $override);
    }
}
