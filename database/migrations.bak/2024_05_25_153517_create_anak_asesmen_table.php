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
        Schema::create('anak_asesmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')
                ->index()
                ->references('id')->on('anak')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('jenis_asesmen_id')
                ->index()
                ->references('id')->on('m_jenis_asesmen')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->integer('urutan');
            $table->text('keterangan')->nullable();
            $table->text('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_asesmen');
    }
};
