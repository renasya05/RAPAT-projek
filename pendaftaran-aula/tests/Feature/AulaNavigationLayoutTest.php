<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AulaNavigationLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_aula_list_hides_sidebar_and_shows_a_back_link(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('aulas'))
            ->assertOk()
            ->assertSee('class="is-user is-full is-aula-list"', false)
            ->assertSee('Kembali');
    }

    public function test_user_registration_form_hides_sidebar_and_shows_a_back_link_to_aula_list(): void
    {
        $user = User::factory()->create();
        $aula = Aula::create([
            'nama_aula' => 'Aula Uji',
            'kapasitas' => 100,
            'keterangan' => 'Aula untuk pengujian',
        ]);

        $this->actingAs($user)
            ->get(route('pendaftaran.create', $aula))
            ->assertOk()
            ->assertSee('class="is-user is-full"', false)
            ->assertSee('Kembali ke Daftar Aula');
    }
}
