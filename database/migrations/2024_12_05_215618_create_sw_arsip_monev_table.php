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
        // create table sw_periode_monev
        Schema::create('sw_periode_monev', function (Blueprint $table) {
            $table->id();
            $table->text('periode');
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create table sw_arsip_monev
        Schema::create('sw_arsip_monev', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_monev');
            $table->text('judul_monev');
            $table->unsignedBigInteger('periode_monev_id')->nullable();
            $table->text('path_laporan_monev_pdf');
            $table->text('path_laporan_monev_word');
            $table->unsignedBigInteger('diunggah');
            $table->timestamps();

            $table->foreign('periode_monev_id')->references('id')->on('sw_periode_monev')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_arsip_monev');
        Schema::dropIfExists('sw_periode_monev');
    }
};
