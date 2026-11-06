<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;

class AdminRiwayatTest extends FeatureTestCase
{
    private function daftar(): Pendaftaran
    {
        $aula = $this->aula();

        return Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'peserta_asal' => 'internal',
            'unit_organisasi' => 'Sekretariat',
            'tanggal_mulai' => now()->addDays(2),
            'tanggal_selesai' => now()->addDays(2),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);
    }

    public function test_status_kosong_tetap_menandai_tombol_semua(): void
    {
        $this->daftar();

        $this->actingAs($this->user('admin'))
            ->get(route('admin.pendaftaran.index', ['status' => '']))
            ->assertOk()
            ->assertSee('class="filter-btn active"', false);
    }

    public function test_status_ngawur_dianggap_semua(): void
    {
        $this->daftar();

        $this->actingAs($this->user('admin'))
            ->get(route('admin.pendaftaran.index', ['status' => 'ngawur']))
            ->assertOk()
            ->assertSee('class="filter-btn active"', false);
    }

    public function test_filter_status_bekerja(): void
    {
        $menunggu = $this->daftar();

        $disetujui = $this->daftar();
        $disetujui->update(['status' => 'disetujui']);

        $this->actingAs($this->user('admin'))
            ->get(route('admin.pendaftaran.index', ['status' => 'disetujui']))
            ->assertOk()
            ->assertSee('Budi')
            ->assertSee('Disetujui');
    }

    public function test_catatan_penolakan_kosong_menampilkan_error(): void
    {
        $pendaftaran = $this->daftar();

        $this->actingAs($this->user('admin'))
            ->from(route('admin.pendaftaran.show', $pendaftaran))
            ->put(route('admin.pendaftaran.reject', $pendaftaran), [
                'catatan_admin' => '',
            ])
            ->assertRedirect(route('admin.pendaftaran.show', $pendaftaran))
            ->assertSessionHasErrors('catatan_admin');

        $this->assertSame('menunggu', $pendaftaran->fresh()->status);
    }

    public function test_catatan_penolakan_lebih_dari_1000_karakter_menampilkan_error(): void
    {
        $pendaftaran = $this->daftar();

        $this->actingAs($this->user('admin'))
            ->from(route('admin.pendaftaran.show', $pendaftaran))
            ->put(route('admin.pendaftaran.reject', $pendaftaran), [
                'catatan_admin' => str_repeat('a', 1001),
            ])
            ->assertSessionHasErrors('catatan_admin');

        $this->assertSame('menunggu', $pendaftaran->fresh()->status);
    }
}
