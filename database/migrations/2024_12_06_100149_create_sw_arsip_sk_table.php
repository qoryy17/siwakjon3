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
        Schema::create('sw_arsip_sk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor');
            $table->text('judul');
            $table->date('tanggal_terbit');
            $table->text('path_file_sk');
            $table->enum('status', ['Berlaku', 'Tidak Berlaku'])->default('Tidak Berlaku');
            $table->unsignedBigInteger('diunggah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_arsip_sk');
    }
};
