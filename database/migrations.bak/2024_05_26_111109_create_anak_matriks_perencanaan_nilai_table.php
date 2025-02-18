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
        Schema::create('anak_matriks_perencanaan_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_matriks_perencanaan_id')
                ->index()
                ->references('id')->on('anak_matriks_perencanaan')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('matriks_perencanaan_subitem_id')
                ->nullable()
                ->index()
                ->references('id')->on('matriks_perencanaan_subitem')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('status', ['+', '-', '0'])
                ->nullable()
                ->comment('+ [Kekuatan]; - [Kelemahan]; 0 [Kelemahan]');
            $table->text('diagnosa')->nullable();
            $table->text('karateristik')->nullable();
            $table->text('dampak')->nullable();
            $table->text('strategi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_matriks_perencanaan_nilai');
    }
};
