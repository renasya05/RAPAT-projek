<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('nip')
                ->nullable()
                ->after('nama_pemohon');

            $table->string('jabatan')
                ->nullable()
                ->after('nip');

            $table->string('unit_organisasi')
                ->nullable()
                ->after('instansi');

            $table->enum('peserta_pihak_luar', ['ada', 'tidak_ada'])
                ->default('tidak_ada')
                ->after('jumlah_peserta');

            // SQLite menolak drop column yang masih diindeks.
            $table->dropIndex(['jenis_kegiatan']);

            $table->dropColumn([
                'jenis_kegiatan',
                'peserta_instansi',
                'peserta_luar',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->enum('jenis_kegiatan', [
                'instansi',
                'pihak_luar',
                'gabungan'
            ])->nullable();

            $table->index('jenis_kegiatan');

            $table->unsignedInteger('peserta_instansi')
                ->default(0);

            $table->unsignedInteger('peserta_luar')
                ->default(0);

            $table->dropColumn([
                'nip',
                'jabatan',
                'unit_organisasi',
                'peserta_pihak_luar',
            ]);
        });
    }
};