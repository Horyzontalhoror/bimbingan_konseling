<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSumberToRekomendasiSiswaTable extends Migration
{
    public function up()
    {
        Schema::table('rekomendasi_siswa', function (Blueprint $table) {
            $table->string('sumber')->after('metode')->nullable()
                  ->comment('Menandakan asal rekomendasi: kmeans / knn');
        });
    }

    public function down()
    {
        Schema::table('rekomendasi_siswa', function (Blueprint $table) {
            $table->dropColumn('sumber');
        });
    }
}
