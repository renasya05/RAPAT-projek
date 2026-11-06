<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'jenis_aula')) {
                $table->dropColumn('jenis_aula');
            }

            if (Schema::hasColumn('pendaftarans', 'nomor_hp')) {
                $table->dropColumn('nomor_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // 2026_09_21_124758 juga mengembalikan jenis_aula;
            // tanpa guard, rollback satu batch gagal dengan duplicate column.
            if (!Schema::hasColumn('pendaftarans', 'jenis_aula')) {
                $table->string('jenis_aula')->nullable();
            }

            $table->string('nomor_hp')->nullable();
        });
    }
};