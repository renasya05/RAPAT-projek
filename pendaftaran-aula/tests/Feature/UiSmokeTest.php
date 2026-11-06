<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;

class UiSmokeTest extends FeatureTestCase
{
    private function pendaftaran(string $status = 'menunggu', ?\App\Models\User $pemohon = null): Pendaftaran
    {
        return Pendaftaran::create([
            'user_id' => ($pemohon ?? $this->user())->id,
            'aula_id' => $this->aula()->id,
            'nama_pemohon' => 'Budi Santoso',
            'jabatan' => 'Analis',
            'peserta_asal' => 'internal',
            'unit_organisasi' => 'Sekretariat',
            'bagian_seksi' => 'Subbagian Umum',
            'instansi' => 'DISKOMINFO',
            'tanggal_mulai' => now()->addDays(4),
            'tanggal_selesai' => now()->addDays(4),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat koordinasi',
            'status' => $status,
        ]);
    }

    public function test_halaman_tamu_dapat_diakses(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('sapa.css', false);
        $this->get(route('register'))->assertOk()->assertSee('sapa.css', false);
        $this->get('/')->assertRedirect(route('login'));
    }

    public function test_seluruh_halaman_pengguna_terender(): void
    {
        $pengguna = $this->user();
        $aula = $this->aula();
        $pengajuan = $this->pendaftaran('menunggu', $pengguna);

        $halaman = [
            route('dashboard'),
            route('aulas'),
            route('informasi'),
            route('pendaftaran.create', $aula),
            route('pendaftaran.history'),
            route('pendaftaran.show', $pengajuan),
        ];

        foreach ($halaman as $url) {
            $this->actingAs($pengguna)
                ->get($url)
                ->assertOk()
                ->assertSee('js/sapa.js', false);
        }
    }

    public function test_seluruh_halaman_admin_terender(): void
    {
        $admin = $this->user('admin');
        $aula = $this->aula();
        $pengajuan = $this->pendaftaran();

        $halaman = [
            route('admin.dashboard'),
            route('admin.laporan'),
            route('admin.aulas.index'),
            route('admin.aulas.create'),
            route('admin.aulas.show', $aula),
            route('admin.aulas.edit', $aula),
            route('admin.pendaftaran.index'),
            route('admin.pendaftaran.show', $pengajuan),
        ];

        foreach ($halaman as $url) {
            $this->actingAs($admin)
                ->get($url)
                ->assertOk()
                ->assertSee('js/sapa.js', false);
        }
    }

    public function test_riwayat_pengguna_tampil_untuk_setiap_status(): void
    {
        $pengguna = $this->user();

        foreach (['menunggu', 'disetujui', 'ditolak', 'dibatalkan'] as $status) {
            $pengajuan = $this->pendaftaran($status, $pengguna);

            $this->actingAs($pengguna)
                ->get(route('pendaftaran.show', $pengajuan))
                ->assertOk();
        }
    }

    public function test_appbar_menyertakan_jam_notifikasi_dan_profil(): void
    {
        $this->pendaftaran();

        $this->actingAs($this->user())
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('id="tbDay"', false)
            ->assertSee('id="tbTime"', false)
            ->assertSee('id="tbNotifPanel"', false)
            ->assertSee('id="tbProfilePanel"', false)
            ->assertSee('data-nav-toggle', false);
    }
}
