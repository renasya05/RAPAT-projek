<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Konversi data lama
        |--------------------------------------------------------------------------
        |
        | Data lama:
        | pagi  -> pagi_siang
        | siang -> siang_sore
        | sore  -> siang_sore
        | malam -> malam
        |
        */

        DB::table('pendaftarans')
            ->where('kriteria_waktu', 'pagi')
            ->update([
                'kriteria_waktu' => 'pagi_siang',
            ]);

        DB::table('pendaftarans')
            ->where('kriteria_waktu', 'siang')
            ->update([
                'kriteria_waktu' => 'siang_sore',
            ]);

        DB::table('pendaftarans')
            ->where('kriteria_waktu', 'sore')
            ->update([
                'kriteria_waktu' => 'siang_sore',
            ]);

        DB::table('pendaftarans')
            ->where('kriteria_waktu', 'malam')
            ->update([
                'kriteria_waktu' => 'malam',
            ]);
    }

    public function down(): void
    {
        DB::table('pendaftarans')
            ->where('kriteria_waktu', 'pagi_siang')
            ->update([
                'kriteria_waktu' => 'pagi',
            ]);

        DB::table('pendaftarans')
            ->where('kriteria_waktu', 'siang_sore')
            ->update([
                'kriteria_waktu' => 'siang',
            ]);
    }
};