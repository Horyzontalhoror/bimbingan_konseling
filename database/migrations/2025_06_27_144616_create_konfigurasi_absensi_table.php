<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konfigurasi_absensi', function (Blueprint $table) {
            $table->id();
            $table->integer('max_alpa');
            $table->integer('max_sakit');
            $table->string('kategori_if'); // contoh: "Butuh Bimbingan"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_absensi');
    }
};
