<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rekomendasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->string('kategori'); // Baik / Cukup / Butuh Bimbingan
            $table->string('metode');   // KNN / KMeans
            $table->timestamps();

            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_siswa');
    }
};
