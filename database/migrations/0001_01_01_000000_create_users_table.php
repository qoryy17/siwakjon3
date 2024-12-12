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
        // create table sw_jabatan
        Schema::create('sw_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan');
            $table->string('kode_jabatan');
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create table sw_pegawai
        Schema::create('sw_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('nama');
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->text('foto')->nullable();
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('jabatan_id')->references('id')->on('sw_jabatan')->onDelete('set null')->onUpdate('cascade');
        });

        // create table sw_pejabat_pengganti
        Schema::create('sw_pejabat_pengganti', function (Blueprint $table) {
            $table->id();
            $table->string('pejabat');
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create table sw_unit_kerja
        Schema::create('sw_unit_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('unit_kerja', 300);
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();
        });

        // create table sw_hakim_pengawas
        Schema::create('sw_hakim_pengawas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->unsignedBigInteger('unit_kerja_id')->nullable();
            $table->enum('aktif', ['Y', 'T'])->default('T');
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('sw_pegawai')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('unit_kerja_id')->references('id')->on('sw_unit_kerja')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->enum('active', ['1', '0'])->default('0');
            $table->string('roles');
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('sw_pegawai')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_jabatan');
        Schema::dropIfExists('sw_pegawai');
        Schema::dropIfExists('sw_unit_kerja');
        Schema::dropIfExists('sw_hakim_pengawas');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
