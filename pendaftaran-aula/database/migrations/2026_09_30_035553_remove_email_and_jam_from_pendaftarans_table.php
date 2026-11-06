<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            // Hapus kolom lama
            $table->dropColumn([
                'email',
                'jam_mulai',
                'jam_selesai',
            ]);

            // Tambahkan kriteria waktu
            $table->string('kriteria_waktu', 20)
                ->after('tanggal_selesai');
        });
    }

    /**
     * Balikkan migration.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            // Hapus kriteria waktu
            $table->dropColumn('kriteria_waktu');

            // Kembalikan kolom lama
            $table->string('email')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
        });
    }
};