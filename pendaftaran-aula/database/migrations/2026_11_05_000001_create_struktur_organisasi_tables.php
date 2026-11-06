<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daftar Bidang/Unit dan Subbagian/Seksi dipindah dari kode ke database
     * supaya admin bisa mengubahnya dari halaman "Struktur Organisasi".
     *
     * Isi awal sama persis dengan daftar yang sebelumnya tertulis tetap di
     * PendaftaranController.
     */
    public function up(): void
    {
        Schema::create('unit_organisasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('bagian_seksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_organisasi_id')
                ->constrained('unit_organisasis')
                ->cascadeOnDelete();
            $table->string('nama');
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->unique(['unit_organisasi_id', 'nama']);
        });

        $awal = [
            'Sekretariat' => [
                'Subbagian Perencanaan dan Pelaporan',
                'Subbagian Keuangan dan Aset',
                'Subbagian Umum dan Kepegawaian',
            ],
            'Bidang Informasi Publik dan Statistik' => [
                'Seksi Layanan Informasi Publik',
                'Seksi Pengelolaan Informasi Publik dan Media',
                'Seksi Pengelolaan Data Statistik',
            ],
            'Bidang Komunikasi Publik' => [
                'Seksi Pengelolaan Opini Publik',
                'Seksi Sumber Daya Komunikasi Publik dan Kehumasan',
                'Seksi Kemitraan Komunikasi Publik dan Hubungan Media',
            ],
            'Bidang Aplikasi Informatika' => [
                'Seksi Pengembangan Aplikasi',
                'Seksi Infrastruktur E-Government',
                'Seksi Tata Kelola dan Ekosistem E-Government',
            ],
            'Bidang Persandian dan Keamanan Informasi' => [
                'Seksi Pengembangan Kapasitas Tata Kelola Persandian dan Keamanan Informasi',
                'Seksi Layanan Persandian dan Keamanan Informasi',
                'Seksi Monitoring, Evaluasi dan Audit Persandian dan Keamanan Informasi',
            ],
        ];

        $sekarang = now();
        $urutUnit = 1;

        foreach ($awal as $namaUnit => $daftarSeksi) {

            $unitId = DB::table('unit_organisasis')->insertGetId([
                'nama' => $namaUnit,
                'urutan' => $urutUnit++,
                'aktif' => true,
                'created_at' => $sekarang,
                'updated_at' => $sekarang,
            ]);

            $urutSeksi = 1;

            foreach ($daftarSeksi as $namaSeksi) {
                DB::table('bagian_seksis')->insert([
                    'unit_organisasi_id' => $unitId,
                    'nama' => $namaSeksi,
                    'urutan' => $urutSeksi++,
                    'aktif' => true,
                    'created_at' => $sekarang,
                    'updated_at' => $sekarang,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bagian_seksis');
        Schema::dropIfExists('unit_organisasis');
    }
};