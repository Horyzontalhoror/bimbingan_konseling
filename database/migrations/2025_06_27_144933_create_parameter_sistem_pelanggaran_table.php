<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parameter_sistem_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->integer('skor_min');
            $table->integer('skor_max');
            $table->string('kategori'); // Contoh: Baik / Cukup / Butuh Bimbingan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameter_sistem_pelanggaran');
    }
};
