<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;

class PendaftaranBentrokTest extends FeatureTestCase
{
    public function test_slot_yang_sama_tidak_bisa_didaftarkan_dua_kali(): void
    {
        $user = $this->user();
        $aula = $this->aula();

        $tanggal = now()->addDays(5)->format('Y-m-d');

        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
        ]))->assertRedirect(route('pendaftaran.history'));

        $this->assertSame(1, Pendaftaran::count());

        // Pengajuan kedua untuk slot yang sama harus ditolak.
        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
        ]))->assertSessionHasErrors('kriteria_waktu');

        $this->assertSame(
            1,
            Pendaftaran::count(),
            'Slot yang sama tidak boleh terisi dua kali.'
        );
    }

    public function test_slot_berbeda_pada_aula_yang_sama_boleh_didaftarkan(): void
    {
        $user = $this->user();
        $aula = $this->aula();

        $tanggal = now()->addDays(5)->format('Y-m-d');

        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'pagi_siang',
        ]));

        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'malam',
        ]))->assertSessionHasNoErrors();

        $this->assertSame(2, Pendaftaran::count());
    }

    public function test_gabungan_slot_bentrok_dengan_slot_pasangan(): void
    {
        $user = $this->user();
        $aula = $this->aula();

        $tanggal = now()->addDays(6)->format('Y-m-d');

        // Pengajuan pertama memakai pagi saja.
        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'pagi_siang',
        ]));

        // Gabungan pagi-malam ikut menabrak karena memuat pagi.
        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => $tanggal,
            'tanggal_selesai' => $tanggal,
            'kriteria_waktu' => 'gabungan_pagi_malam',
        ]))->assertSessionHasErrors('kriteria_waktu');

        $this->assertSame(1, Pendaftaran::count());
    }

    public function test_rentang_beririsan_ditolak(): void
    {
        $user = $this->user();
        $aula = $this->aula();

        // Pengajuan pertama menempati tanggal 10 sampai 12.
        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => now()->addDays(10)->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(12)->format('Y-m-d'),
        ]));

        // Pengajuan kedua mulai di tengah rentang pertama.
        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => now()->addDays(11)->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(13)->format('Y-m-d'),
        ]))->assertSessionHasErrors('kriteria_waktu');

        $this->assertSame(1, Pendaftaran::count());
    }

    public function test_tanggal_yang_berbeda_tidak_bertabrakan(): void
    {
        $user = $this->user();
        $aula = $this->aula();

        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => now()->addDays(10)->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(10)->format('Y-m-d'),
        ]));

        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'tanggal_mulai' => now()->addDays(11)->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(11)->format('Y-m-d'),
        ]))->assertSessionHasNoErrors();

        $this->assertSame(2, Pendaftaran::count());
    }

    public function test_pengajuan_ditolak_kalau_jumlah_peserta_kapasitas_kurang(): void
    {
        $user = $this->user();

        $aula = $this->aula(20);

        $this->actingAs($user)->post(route('pendaftaran.store'), $this->payload([
            'aula_id' => $aula->id,
            'jumlah_peserta' => 50,
        ]))->assertSessionHasErrors('jumlah_peserta');

        $this->assertSame(0, Pendaftaran::count());
    }
}
