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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agama_id')
                ->index()
                ->references('id')->on('m_agama')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])
                ->comment('L = Laki-Laki; P = Perempuan');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nomor_kk');
            $table->string('nik')->unique();
            $table->string('nama_sekolah');
            $table->string('kelas');
            $table->string('nisn')->unique();
            $table->text('foto');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->text('alamat_rumah');
            $table->text('alamat_domisili')->nullable();
            $table->string('nomor_hp');
            $table->string('email');
            $table->text('file_kk');
            $table->text('file_ktp_orang_tua');
            $table->text('file_surat_domisili')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
