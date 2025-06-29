<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konfigurasi_kmeans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_centroid');     // Contoh: C1, C2, C3
            $table->decimal('nilai_centroid', 5, 2); // Nilai rata-rata, contoh: 72.25
            $table->string('kategori');          // Contoh: Baik, Cukup, Butuh Bimbingan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_kmeans');
    }
};
