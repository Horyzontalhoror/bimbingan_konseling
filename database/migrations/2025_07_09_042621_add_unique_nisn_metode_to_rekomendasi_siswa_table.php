<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueNisnMetodeToRekomendasiSiswaTable extends Migration
{
    public function up()
    {
        Schema::table('rekomendasi_siswa', function (Blueprint $table) {
            $table->unique(['nisn', 'metode'], 'unique_nisn_metode');
        });
    }

    public function down()
    {
        Schema::table('rekomendasi_siswa', function (Blueprint $table) {
            $table->dropUnique('unique_nisn_metode');
        });
    }
}
