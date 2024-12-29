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
        Schema::create("sw_kunjungan_pengawasan", function (Blueprint $table) {
            $table->id();
            $table->uuid('kode_kunjungan');
            $table->unsignedBigInteger("unit_kerja_id")->nullable();
            $table->unsignedBigInteger('dibuat');
            $table->timestamps();
            $table->foreign('unit_kerja_id')->references('id')->on('sw_unit_kerja')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('sw_detail_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kunjungan_pengawasan_id');
            $table->date('tanggal');
            $table->string('waktu');
            $table->string('agenda');
            $table->text('pembahasan');
            $table->unsignedBigInteger('hakim_pengawas_id')->nullable();

            $table->foreign('hakim_pengawas_id')->references('id')->on('sw_hakim_pengawas')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('kunjungan_pengawasan_id')->references('id')->on('sw_kunjungan_pengawasan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_kunjungan_pengawasan');
        Schema::dropIfExists('sw_detail_kunjungan');
    }
};
