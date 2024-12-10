<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('log_rekam_medis', function (Blueprint $table) {
            $table->string('action')->after('rekam_medis_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('log_rekam_medis', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }

};
