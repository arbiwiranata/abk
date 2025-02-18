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
        Schema::create('matriks_perencanaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hambatan_id')
                ->index()
                ->references('id')->on('m_hambatan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nama')->unique();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriks_perencanaan');
    }
};
