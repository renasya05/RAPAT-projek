<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Aula;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | AKUN ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => env('ADMIN_EMAIL', 'admin@aula.test'),
            ],
            [
                'name' => 'Administrator',
                'password' => Hash::make(
                    env('ADMIN_PASSWORD', 'password')
                ),
                'role' => 'admin',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | DATA AULA
        |--------------------------------------------------------------------------
        */

        Aula::updateOrCreate(
            [
                'nama_aula' => 'Aula Besar',
            ],
            [
                'kapasitas' => 100,
                'keterangan' => 'Aula dengan kapasitas besar untuk kegiatan dan acara kantor.',
                'fasilitas' => 'Kursi, meja, Audio System, proyektor, videotron, panggung',
            ]
        );

        Aula::updateOrCreate(
            [
                'nama_aula' => 'Aula Kecil',
            ],
            [
                'kapasitas' => 29,
                'keterangan' => 'Aula dengan kapasitas kecil untuk rapat dan kegiatan internal.',
                'fasilitas' => 'Kursi, meja, AC',
            ]
        );
    }
}