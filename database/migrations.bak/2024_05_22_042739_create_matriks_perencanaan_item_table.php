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
        Schema::create('matriks_perencanaan_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matriks_perencanaan_aspek_id')
                ->index()
                ->references('id')->on('matriks_perencanaan_aspek')
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
        Schema::dropIfExists('matriks_perencanaan_item');
    }
};
