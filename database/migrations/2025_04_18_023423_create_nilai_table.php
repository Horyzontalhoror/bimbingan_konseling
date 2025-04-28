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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nisn')->unique();
            $table->string('class');
            $table->float('bindo')->nullable();
            $table->float('bing')->nullable();
            $table->float('mat')->nullable();
            $table->float('ipa')->nullable();
            $table->float('ips')->nullable();
            $table->float('agama')->nullable();
            $table->float('ppkn')->nullable();
            $table->float('sosbud')->nullable();
            $table->float('tik')->nullable();
            $table->float('penjas')->nullable();
            $table->float('jumlah_nilai')->nullable();
            $table->float('rata_rata')->nullable();
            $table->enum('kategori', ['Butuh Bimbingan', 'Cukup', 'Baik'])->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
