<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();

            // Pemohon
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Aula yang dipilih
            $table->foreignId('aula_id')
                ->constrained('aulas')
                ->cascadeOnDelete();

            // Jenis kegiatan:
            // instansi, pihak_luar, gabungan
            $table->enum('jenis_kegiatan', [
                'instansi',
                'pihak_luar',
                'gabungan'
            ]);

            // Data pemohon
            $table->string('nama_pemohon');
            $table->string('instansi')->nullable();
            $table->string('nomor_hp');
            $table->string('email');

            // Jadwal
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // Jumlah peserta
            $table->unsignedInteger('peserta_instansi')->default(0);
            $table->unsignedInteger('peserta_luar')->default(0);
            $table->unsignedInteger('jumlah_peserta');

            // Keperluan
            $table->text('keperluan');

            // Status pengajuan
            $table->string('status')->default('menunggu');

            // Catatan dari admin
            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            // Index untuk mempercepat pengecekan jadwal
            $table->index(['aula_id', 'tanggal']);
            $table->index(['status']);
            $table->index(['jenis_kegiatan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};