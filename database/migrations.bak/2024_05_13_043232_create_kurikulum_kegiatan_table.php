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
        Schema::create('kurikulum_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_target_id')
                ->index()
                ->references('id')->on('kurikulum_target')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('urutan');
            $table->text('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum_kegiatan');
    }
};
