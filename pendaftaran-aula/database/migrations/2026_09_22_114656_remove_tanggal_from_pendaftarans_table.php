<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // SQLite menolak drop column yang masih diindeks.
            $table->dropIndex(['aula_id', 'tanggal']);

            $table->dropColumn('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Nullable: tabel sudah berisi baris, kolom NOT NULL tanpa
            // default tidak bisa ditambahkan ke tabel terisi.
            $table->date('tanggal')->nullable();

            $table->index(['aula_id', 'tanggal']);
        });
    }
};