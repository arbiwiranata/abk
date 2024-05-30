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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atasan_id')
                ->index()
                ->nullable()
                ->references('id')->on('pegawai')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nik')->unique();
            $table->string('nip')->unique()->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])
                ->comment('L = Laki-Laki; P = Perempuan');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->enum('status_pegawai', ['cpns', 'pns', 'pppk', 'non asn'])
                ->comment('cpns; pns; pppk; non asn');
            $table->date('tmt_masuk');
            $table->text('foto')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
