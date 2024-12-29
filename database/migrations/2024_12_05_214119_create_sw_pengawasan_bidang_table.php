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
        // create table sw_pengawasan_bidang
        Schema::create('sw_pengawasan_bidang', function (Blueprint $table) {
            $table->id();
            $table->uuid('kode_pengawasan')->unique();
            $table->unsignedBigInteger('detail_rapat_id')->unique();
            $table->text('objek_pengawasan');
            $table->longText('dasar_hukum');
            $table->text('deskripsi_pengawasan');
            $table->longText('kesimpulan')->nullable();
            $table->longText('rekomendasi')->nullable();
            $table->string('hakim_pengawas');
            $table->enum('status', ['Approve', 'Waiting'])->default('Waiting');
            $table->dateTime('approve_stamp')->nullable();
            $table->timestamps();

            $table->foreign('detail_rapat_id')->references('id')->on('sw_detail_rapat')->onDelete('cascade')->onUpdate('cascade');
        });

        // create table sw_temuan_pengawasan
        Schema::create('sw_temuan_pengawasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengawasan_bidang_id');
            $table->text('judul');
            $table->text('kondisi');
            $table->text('kriteria');
            $table->text('sebab');
            $table->text('akibat');
            $table->text('rekomendasi');
            $table->string('waktu_penyelesaian');
            $table->timestamps();

            $table->foreign('pengawasan_bidang_id')->references('id')->on('sw_pengawasan_bidang')->onDelete('cascade')->onUpdate('cascade');
        });

        // create table sw_edoc_tlhp
        Schema::create('sw_edoc_tlhp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengawasan_bidang_id')->unique();
            $table->text('path_file_tlhp');
            $table->timestamps();

            $table->foreign('pengawasan_bidang_id')->references('id')->on('sw_pengawasan_bidang')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_pengawasan_bidang');
        Schema::dropIfExists('sw_temuan_pengawasan');
        Schema::dropIfExists('sw_edoc_tlhp');
    }
};
