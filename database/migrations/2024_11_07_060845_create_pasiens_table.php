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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap'); // Full Name
            $table->string('alamat'); // Address
            $table->integer('umur'); // Age
            $table->enum('gender', ['Laki-laki', 'Perempuan']); // Gender
            $table->string('pendidikan'); // Education
            $table->string('pekerjaan'); // Job
            $table->date('tanggal_pemeriksaan'); // Examination Date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
