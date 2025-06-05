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
        Schema::create('sw_ai_model', function (Blueprint $table) {
            $table->id();
            $table->string('ai_model');
            $table->text('prompt_catatan_rapat');
            $table->text('prompt_kesimpulan_rapat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_ai_model');
    }
};
