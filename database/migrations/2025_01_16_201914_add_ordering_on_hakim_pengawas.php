<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sw_hakim_pengawas', function (Blueprint $table) {
            $table->integer('ordering')->after('aktif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sw_hakim_pengawas', function (Blueprint $table) {
            $table->dropColumn('ordering');
        });
    }
};
