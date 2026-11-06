<?php

namespace Tests\Feature;

class InformasiTest extends FeatureTestCase
{
    public function test_halaman_informasi_bisa_diakses_user(): void
    {
        $this->actingAs($this->user())
            ->get(route('informasi'))
            ->assertOk();
    }

    public function test_halaman_informasi_menampilkan_kontak_yang_diisi(): void
    {
        config([
            'sapa.kontak_admin' => [
                'telepon' => '08123456789',
                'email' => 'aula@diskominfo.test',
                'alamat' => 'Jl. Contoh No. 1',
            ],
        ]);

        $this->actingAs($this->user())
            ->get(route('informasi'))
            ->assertOk()
            ->assertSee('08123456789')
            ->assertSee('aula@diskominfo.test');
    }

    public function test_halaman_informasi_tetap_aman_saat_kontak_kosong(): void
    {
        config(['sapa.kontak_admin' => []]);

        $this->actingAs($this->user())
            ->get(route('informasi'))
            ->assertOk();
    }
}
