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
        // create sw_klasifikasi_rapat
        Schema::create('sw_klasifikasi_rapat', function (Blueprint $table) {
            $table->id();
            $table->string('rapat');
            $table->string('kode_klasifikasi');
            $table->text('keterangan')->nullable();
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create sw_klasifikasi_surat
        Schema::create('sw_klasifikasi_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat');
            $table->string('kode_klasifikasi');
            $table->text('keterangan')->nullable();
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create sw_klasifikasi_jabatan
        Schema::create('sw_klasifikasi_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan');
            $table->string('kode_jabatan');
            $table->text('keterangan')->nullable();
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create sw_manajemen_rapat
        Schema::create('sw_manajemen_rapat', function (Blueprint $table) {
            $table->id();
            $table->uuid('kode_rapat')->unique();
            $table->string('nomor_indeks');
            $table->string('nomor_dokumen');
            $table->unsignedBigInteger('klasifikasi_rapat_id')->nullable();
            $table->unsignedBigInteger('dibuat');
            $table->unsignedBigInteger('pejabat_penandatangan')->nullable();
            $table->unsignedBigInteger('pejabat_pengganti_id')->nullable();
            $table->timestamps();

            $table->foreign('klasifikasi_rapat_id')->references('id')->on('sw_klasifikasi_rapat')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pejabat_pengganti_id')->references('id')->on('sw_pejabat_pengganti')->onDelete('set null')->onUpdate('cascade');
        });

        // create detail_rapat
        Schema::create('sw_detail_rapat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manajemen_rapat_id')->unique();
            $table->date('tanggal_rapat');
            $table->string('sifat');
            $table->string('lampiran');
            $table->text('perihal');
            $table->text('acara');
            $table->text('agenda');
            $table->string('jam_mulai');
            $table->text('tempat');
            $table->text('peserta');
            $table->text('keterangan');
            // this is field for notula
            $table->string('jam_selesai')->nullable();
            $table->string('pembahasan')->nullable();
            $table->string('pimpinan_rapat')->nullable();
            $table->string('moderator')->nullable();
            $table->unsignedBigInteger('notulen')->nullable();
            $table->longText('catatan')->nullable();
            $table->longText('kesimpulan')->nullable();
            $table->unsignedBigInteger('disahkan')->nullable();
            $table->timestamps();

            $table->foreign('manajemen_rapat_id')->references('id')->on('sw_manajemen_rapat')->onDelete('cascade')->onUpdate('cascade');
        });

        // create sw_dokumentasi_rapat
        Schema::create('sw_dokumentasi_rapat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_rapat_id');
            $table->text('path_file_dokumentasi');
            $table->timestamps();

            $table->foreign('detail_rapat_id')->references('id')->on('sw_detail_rapat')->onDelete('cascade')->onUpdate('cascade');
        });

        // create sw_edoc_rapat
        Schema::create('sw_edoc_rapat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_rapat_id')->unique();
            $table->text('path_file_edoc');
            $table->timestamps();

            $table->foreign('detail_rapat_id')->references('id')->on('sw_detail_rapat')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_klasifikasi_rapat');
        Schema::dropIfExists('sw_klasifikasi_surat');
        Schema::dropIfExists('sw_klasifikasi_jabatan');
        Schema::dropIfExists('sw_manajemen_rapat');
        Schema::dropIfExists('sw_detail_rapat');
        Schema::dropIfExists('sw_dokumentasi_rapat');
        Schema::dropIfExists('sw_edoc_rapat');
    }
};
