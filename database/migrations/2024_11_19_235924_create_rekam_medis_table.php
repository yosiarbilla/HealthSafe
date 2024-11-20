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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->text('keluhan');
            $table->text('diagnosis');
            $table->text('obat');
            $table->dateTime('tanggal_pemeriksaan');
            $table->timestamps();

            // Relasi ke tabel pasien
            $table->foreign('pasien_id')
                  ->references('id')
                  ->on('pasiens')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
