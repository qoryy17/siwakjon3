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
        // create table sw_pengaturan
        Schema::create('sw_pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('lembaga');
            $table->string('badan_peradilan');
            $table->string('wilayah_hukum');
            $table->string('kode_satker');
            $table->string('satuan_kerja');
            $table->text('alamat');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kode_pos');
            $table->string('telepon');
            $table->string('email');
            $table->string('website');
            $table->text('logo');
            $table->text('license');
            $table->timestamps();
        });

        // create table sw_versi
        Schema::create('sw_versi', function (Blueprint $table) {
            $table->id();
            $table->date('release_date');
            $table->string('category');
            $table->string('patch_version');
            $table->text('note');
            $table->timestamps();
        });

        // create table sw_catatan_pengembang
        Schema::create('sw_catatan_pengembang', function (Blueprint $table) {
            $table->id();
            $table->longText('catatan');
            $table->unsignedBigInteger('pengembang');
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create table sw_logs
        Schema::create('sw_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->ipAddress();
            $table->text('user_agent');
            $table->text('activity');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onDelete('cascade');
        });

        // create table sw_set_nomor_rapat
        Schema::create('sw_set_nomor_rapat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rapat_dinas');
            $table->string('kode_pengawasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_pengaturan');
        Schema::dropIfExists('sw_versi');
        Schema::dropIfExists('sw_catatan_pengembang');
        Schema::dropIfExists('sw_set_nomor_rapat');
    }
};
