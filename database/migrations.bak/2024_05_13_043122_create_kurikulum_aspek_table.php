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
        Schema::create('kurikulum_aspek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_id')
                ->index()
                ->references('id')->on('kurikulum')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('urutan');
            $table->string('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum_aspek');
    }
};
