<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;

class PendaftaranAvailabilityTest extends FeatureTestCase
{
    public function test_endpoint_ketersediaan_melaporkan_slot_yang_tidak_bisa_dipakai(): void
    {
        $user = $this->user();
        $aula = $this->aula();

        $tanggal = now()->addDays(8)->format('Y-m-d');

        // Belum ada apa-apa, semua slot harus bebas.
        $this->actingAs($user)
            ->getJson(route('pendaftaran.availability', [
                'aula_id' => $aula->id,
                'tanggal_mulai' => $tanggal,
                'tanggal_selesai' => $tanggal,
            ]))
            ->assertOk()
            ->assertJsonPath('slotTerpakai', []);

        Pendaftaran::create([
            'user_id' => $user->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Siti',
            'jabatan' => 'Analis',
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'disetujui',
        ]);

        // Setelah ada booking pagi, slot pagi harus terpakai.
        $this->actingAs($user)
            ->getJson(route('pendaftaran.availability', [
                'aula_id' => $aula->id,
                'tanggal_mulai' => $tanggal,
                'tanggal_selesai' => $tanggal,
            ]))
            ->assertOk()
            ->assertJsonPath('slotTerpakai', ['pagi']);
    }

    public function test_approve_menolak_pengajuan_yang_sudah_bentrok(): void
    {
        $admin = $this->user('admin');
        $aula = $this->aula();

        $tanggal = now()->addDays(9)->format('Y-m-d');

        // Sudah ada yang disetujui di slot pagi.
        Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Siti',
            'jabatan' => 'Analis',
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'disetujui',
        ]);

        // Menunggu pengajuan yang sama slotnya.
        $antrean = Pendaftaran::create([
            'user_id' => $this->user()->id,
            'aula_id' => $aula->id,
            'nama_pemohon' => 'Andi',
            'jabatan' => 'Analis',
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'pagi_siang',
            'jumlah_peserta' => 10,
            'keperluan' => 'Rapat',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.pendaftaran.approve', $antrean));

        $this->assertSame(
            'menunggu',
            $antrean->fresh()->status,
            'Slot yang sudah disetujui tidak boleh disetujui lagi.'
        );
    }

    public function test_halaman_daftar_terlihat_oleh_admin_bukan_user_biasa(): void
    {
        $this->actingAs($this->user())
            ->get(route('admin.pendaftaran.index'))
            ->assertRedirect(route('dashboard'));
    }
}
