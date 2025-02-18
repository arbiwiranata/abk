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
        Schema::create('anak_hambatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')
                ->index()
                ->references('id')->on('anak')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('hambatan_id')
                ->index()
                ->references('id')->on('m_hambatan')
                ->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_hambatan');
    }
};
