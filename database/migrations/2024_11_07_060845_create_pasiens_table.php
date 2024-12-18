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
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->integer('umur');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->date('tanggal_pemeriksaan');
            $table->timestamps();
            $table->string('status')->default('antri');
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
