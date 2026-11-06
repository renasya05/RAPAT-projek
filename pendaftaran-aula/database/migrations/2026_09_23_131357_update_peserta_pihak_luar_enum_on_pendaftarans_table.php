<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom peserta_pihak_luar sudah tidak digunakan
        // dan digantikan oleh peserta_asal.
        if (Schema::hasColumn('pendaftarans', 'peserta_pihak_luar')) {
            Schema::table('pendaftarans', function (Blueprint $table) {
                $table->dropColumn('peserta_pihak_luar');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->enum('peserta_pihak_luar', ['ada', 'tidak'])
                ->default('tidak')
                ->after('jumlah_peserta');
        });
    }
};