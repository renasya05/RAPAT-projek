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
            $table->string('bagian_seksi')
                ->nullable()
                ->after('unit_organisasi');

            $table->date('tanggal_mulai')
                ->nullable()
                ->after('email');

            $table->date('tanggal_selesai')
                ->nullable()
                ->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'bagian_seksi',
                'tanggal_mulai',
                'tanggal_selesai',
            ]);
        });
    }
};