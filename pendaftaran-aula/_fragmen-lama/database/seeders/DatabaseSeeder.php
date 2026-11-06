<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@aula.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@aula.test'],
            [
                'name' => 'Pengguna Demo',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        Aula::updateOrCreate(
            ['nama_aula' => 'Aula Besar'],
            [
                'kapasitas' => 100,
                'keterangan' => 'Aula untuk seminar, rapat besar, pelatihan, dan kegiatan kantor berskala besar.',
                'fasilitas' => 'Proyektor, sound system, AC, kursi, meja, whiteboard',
            ]
        );

        Aula::updateOrCreate(
            ['nama_aula' => 'Aula Kecil'],
            [
                'kapasitas' => 30,
                'keterangan' => 'Aula untuk rapat kecil, diskusi, koordinasi, dan kegiatan internal.',
                'fasilitas' => 'Proyektor, AC, kursi, meja, whiteboard',
            ]
        );
    }
}
