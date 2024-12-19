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
        // create table sw_periode_monev
        Schema::create('sw_periode_monev', function (Blueprint $table) {
            $table->id();
            $table->text('periode');
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create table sw_periode_monev
        Schema::create('sw_agenda_monev', function (Blueprint $table) {
            $table->id();
            $table->uuid('nomor_agenda');
            $table->unsignedBigInteger('unit_kerja_id')->nullable();
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->unsignedBigInteger('dibuat')->nullable();
            $table->timestamps();

            $table->foreign('unit_kerja_id')->references('id')->on('sw_unit_kerja')->onDelete('set null')->onUpdate('cascade');
        });

        // create table sw_arsip_monev
        Schema::create('sw_arsip_monev', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agenda_monev_id');
            $table->text('judul_monev');
            $table->date('tanggal_monev');
            $table->unsignedBigInteger('periode_monev_id')->nullable();
            $table->text('path_monev')->nullable();
            $table->enum('status', ['Terlambat', 'Tepat Waktu', 'Menunggu'])->default('Terlambat');
            $table->unsignedBigInteger('diunggah')->nullable();
            $table->dateTime('waktu_unggah')->nullable();
            $table->timestamps();

            $table->foreign('agenda_monev_id')->references('id')->on('sw_agenda_monev')->onDelete('cascade')->onUpdate('cascade');
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
