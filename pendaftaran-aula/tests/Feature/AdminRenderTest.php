<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;

class AdminRenderTest extends FeatureTestCase
{
    public function test_halaman_penolakan_menampilkan_error_dan_membuka_modal(): void
    {
        $aula = $this->aula();

        $pendaftaran = Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(2),
            'tanggal_selesai' => now()->addDays(2),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        $this->actingAs($this->user('admin'))
            ->from(route('admin.pendaftaran.show', $pendaftaran))
            ->put(route('admin.pendaftaran.reject', $pendaftaran), [
                'catatan_admin' => '',
            ]);

        $this->actingAs($this->user('admin'))
            ->get(route('admin.pendaftaran.show', $pendaftaran))
            ->assertOk()
            ->assertSee('maxlength="1000"', false)
            ->assertSee('data-modal-open="rejectModal"', false)
            ->assertSee('modal-overlay show', false);
    }

    public function test_asal_peserta_dari_kolom_peserta_asal(): void
    {
        $aula = $this->aula();

        $pemohon = $this->user();

        $pendaftaran = Pendaftaran::create([
            'user_id' => $pemohon->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'peserta_asal' => 'internal_eksternal',
            'unit_organisasi' => 'Sekretariat',
            'bagian_seksi' => 'Subbagian Umum dan Kepegawaian',
            'instansi' => 'Dinas luar',
            'tanggal_mulai' => now()->addDays(2),
            'tanggal_selesai' => now()->addDays(2),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        $this->actingAs($pemohon)
            ->get(route('pendaftaran.show', $pendaftaran))
            ->assertOk()
            ->assertSee('Internal & Eksternal', false);
    }

    public function test_waktu_di_halaman_aula_menggunakan_kriteria_bukan_jam_server(): void
    {
        $aula = $this->aula();

        Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(2),
            'tanggal_selesai' => now()->addDays(2),
            'kriteria_waktu' => 'gabungan_pagi_malam',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'disetujui',
        ]);

        $this->actingAs($this->user('admin'))
            ->get(route('admin.aulas.show', $aula))
            ->assertOk()
            ->assertSee('08.00 - 21.00', false);
    }
}
