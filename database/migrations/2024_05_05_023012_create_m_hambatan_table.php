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
        Schema::create('m_hambatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_hambatan_id')
                ->index()
                ->references('id')->on('m_jenis_hambatan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nama')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_hambatan');
    }
};
