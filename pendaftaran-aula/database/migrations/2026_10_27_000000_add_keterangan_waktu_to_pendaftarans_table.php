<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keterangan jam untuk pilihan Full Day (contoh: "10.00 - 12.00").
     * Hanya catatan untuk admin, tidak memengaruhi cek ketersediaan:
     * Full Day tetap menutup aula seharian.
     */
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('keterangan_waktu', 50)
                ->nullable()
                ->after('kriteria_waktu');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('keterangan_waktu');
        });
    }
};