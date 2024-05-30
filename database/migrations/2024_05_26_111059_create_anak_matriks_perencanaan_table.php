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
        Schema::create('anak_matriks_perencanaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_tahun_ajar_id')
                ->index()
                ->references('id')->on('anak_tahun_ajar')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('matriks_perencanaan_id')
                ->nullable()
                ->index()
                ->references('id')->on('matriks_perencanaan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pegawai_id')
                ->index()
                ->references('id')->on('pegawai')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('jabatan_id')
                ->index()
                ->references('id')->on('m_jabatan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('status', ['R', 'D', 'S', 'SD', 'F'])
                ->default('R')
                ->comment('R = Raw [Create Admin]; D = Draft [On Progress]; S = Submit [Submit Terapis Untuk Key Terapis]; SD = Draft [On Progres Key Terapis]; F = Final [Selesai]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_matriks_perencanaan');
    }
};
