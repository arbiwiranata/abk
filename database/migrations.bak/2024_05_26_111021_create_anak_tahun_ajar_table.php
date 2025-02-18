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
        Schema::create('anak_tahun_ajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')
                ->index()
                ->references('id')->on('anak')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('tahun_ajar_id')
                ->index()
                ->references('id')->on('m_tahun_ajar')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('jenis_layanan_id')
                ->index()
                ->references('id')->on('m_jenis_layanan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('kurikulum_id')
                ->index()
                ->nullable()
                ->references('id')->on('kurikulum')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('terapis_id')
                ->index()
                ->nullable()
                ->references('id')->on('pegawai')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('key_terapis_id')
                ->index()
                ->nullable()
                ->references('id')->on('pegawai')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->text('kesimpulan')->nullable();
            $table->text('saran')->nullable();
            $table->enum('status', ['MP', 'PT', 'SH', 'R'])
                ->default('MP')
                ->comment('MP = Matriks Perencanaan; PT = Program Terapi; SH = Skenario Harian; R = Report');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_tahun_ajar');
    }
};
