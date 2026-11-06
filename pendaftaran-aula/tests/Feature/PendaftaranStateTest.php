<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Pendaftaran;

class PendaftaranStateTest extends FeatureTestCase
{
    public function test_menolak_pengajuan_yang_sudah_diproses_gagal(): void
    {
        $admin = $this->user('admin');
        $pendaftaran = Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $this->aula()->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'disetujui',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.pendaftaran.reject', $pendaftaran), [
                'catatan_admin' => 'Ruangganya sudah dipakai.',
            ])
            ->assertRedirect();

        $this->assertSame(
            'disetujui',
            $pendaftaran->fresh()->status,
            'Pengajuan yang sudah disetujui tidak boleh ditolak.'
        );
    }

    public function test_menolak_pengajuan_yang_sudah_dibatalkan_user_gagal(): void
    {
        $admin = $this->user('admin');
        $pendaftaran = Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $this->aula()->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'dibatalkan',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.pendaftaran.reject', $pendaftaran), [
                'catatan_admin' => 'Tidak relevan.',
            ]);

        $this->assertSame(
            'dibatalkan',
            $pendaftaran->fresh()->status,
            'Pengajuan yang sudah dibatalkan user tidak boleh ditolak.'
        );
    }

    public function test_menolak_pengajuan_menunggu_berhasil(): void
    {
        $admin = $this->user('admin');
        $pendaftaran = Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $this->aula()->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.pendaftaran.reject', $pendaftaran), [
                'catatan_admin' => 'Ruangan sedang dipakai urusan lain.',
            ])
            ->assertRedirect();

        $this->assertSame('ditolak', $pendaftaran->fresh()->status);
    }

    public function test_menyetujui_pengajuan_dengan_kriteria_waktu_tak_dikenal_ditolak(): void
    {
        $admin = $this->user('admin');

        $aula = $this->aula();

        // Slot pagi sudah dipakai pengajuan disetujui lain.
        Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Siti',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'disetujui',
        ]);

        // Pengajuan ini punya kriteria waktu yang tidak dikenal,
        // sehingga whereIn akan menerima array kosong.
        $aneh = Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Andi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'tidak_dikenal',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.pendaftaran.approve', $aneh));

        $this->assertSame(
            'menunggu',
            $aneh->fresh()->status,
            'Kriteria waktu tak dikenal tidak boleh lolos cek bentrok.'
        );
    }

    public function test_pembatalan_gagal_kalau_status_sudah_berubah(): void
    {
        $user = $this->user();

        $pendaftaran = Pendaftaran::create([
            'user_id' => $user->id,
            'aula_id' => $this->aula()->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        // Simulasikan admin menyetujui tepat sebelum user menekan
        // tombol batal pada form yang sudah terbuka.
        $pendaftaran->update(['status' => 'disetujui']);

        $this->actingAs($user)
            ->put(route('pendaftaran.cancel', $pendaftaran))
            ->assertRedirect();

        $this->assertSame(
            'disetujui',
            $pendaftaran->fresh()->status,
            'Pengajuan yang sudah disetujui tidak boleh jadi dibatalkan.'
        );
    }

    public function test_pengguna_tidak_bisa_membatalkan_pengajuan_milik_orang_lain(): void
    {
        $pemilik = $this->user();
        $orangLain = $this->user();

        $pendaftaran = Pendaftaran::create([
            'user_id' => $pemilik->id,
            'aula_id' => $this->aula()->id,
            'nama_pemohon' => 'Budi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(3),
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        $this->actingAs($orangLain)
            ->put(route('pendaftaran.cancel', $pendaftaran))
            ->assertForbidden();

        $this->assertSame('menunggu', $pendaftaran->fresh()->status);
    }
}
