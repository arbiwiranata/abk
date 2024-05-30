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
        Schema::create('pegawai_jabatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')
                ->index()
                ->references('id')->on('pegawai')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('jabatan_id')
                ->index()
                ->references('id')->on('m_jabatan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_jabatan');
    }
};
